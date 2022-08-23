<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Sender;
use App\Models\Receiver;
use App\Models\Item;
use App\Models\User;

class ItemController extends Controller
{
    const PATH = 'assets/img/payment/';

    public function index()
    {
        return view('customer.item.index', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
            'items' => $this->getAllItems(),
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    public function createItem()
    {
        return view('customer.item.create', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
        ]);
    }

    public function storeItem(Request $request)
    {
        if ($this->bankIsNotAvailable()) {
            return redirect()->route('customer.item')->with('error', 'Agen tidak tersedia!');
        }

        $bank = $this->getFirstBank();

        if (!$request->use_self) {
            $this->validateSender($request);
            $this->validateReceiver($request);
            $this->validateItem($request);

            // create sender
            $sender = Sender::create([
                'name' => $request->sender_name,
                'phone' => $request->sender_phone,
                'address' => $request->sender_address,
                'detail_address' => $request->sender_detail_address,
            ]);

            // create receiver
            $receiver = Receiver::create([
                'name' => $request->receiver_name,
                'phone' => $request->receiver_phone,
                'address' => $request->receiver_address,
                'detail_address' => $request->receiver_detail_address,
            ]);

            // create item
            Item::create([
                'user_id' => auth()->user()->id,
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'weight' => $request->weight,
                'status' => 'request',
                'note' => $request->note,
                'bank_id' => $bank->id,
            ]);

            return redirect()->route('customer.item')->with('success', 'Paket anda sudah kami terima, silahkan tunggu konfirmasi dari agen');
        } else {
            $request->merge([
                'sender_name' => null,
                'sender_phone' => null,
                'sender_address' => null,
                'sender_detail_address' => null,
            ]);
            $this->validateReceiver($request);
            $this->validateItem($request);

            if (!$this->validateSelf()) {
                return redirect()->route('customer.item')->with('error', 'Anda tidak bisa mengirim paket, lengkapi data diri anda!');
            } else {
                // create receiver
                $receiver = Receiver::create([
                    'name' => $request->receiver_name,
                    'phone' => $request->receiver_phone,
                    'address' => $request->receiver_address,
                    'detail_address' => $request->receiver_detail_address,
                ]);

                // creaete sender
                $sender = Sender::create([
                    'name' => auth()->user()->name,
                    'phone' => auth()->user()->phone,
                    'address' => auth()->user()->address,
                    'detail_address' => auth()->user()->detail_address,
                ]);

                // create item
                Item::create([
                    'user_id' => auth()->user()->id,
                    'sender_id' => $sender->id,
                    'receiver_id' => $receiver->id,
                    'weight' => $request->weight,
                    'status' => 'request',
                    'note' => $request->note,
                    'bank_id' => $bank->id,
                ]);
            }
        }
    }

    public function confirmYes(Item $item)
    {
        $item->update([
            'status' => 'ok',
        ]);
        return redirect()->route('customer.item')->with('success', 'Berhasil mengkonfirmasi paket, harap lakukan pembayaran!');
    }

    public function confirmNo(Item $item)
    {
        $item->update([
            'status' => 'canceled',
        ]);
        return redirect()->route('customer.item')->with('success', 'Berhasil mengkonfirmasi paket, paket anda dibatalkan!');
    }

    private function bankIsNotAvailable()
    {
        $count = Bank::count();
        if ($count == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function paymentItem(Item $item, Request $request)
    {
        if (!$this->checkPayment($request)) {
            return redirect()->route('customer.item')->with('error', 'Gagal melakukan pembayaran, silahkan pilih kategori pembayaran!');
        }

        if ($request->payment == 'cod') {
            $item->update([
                'proof' => $request->payment,
                'status' => 'paid',
            ]);
            return redirect()->route('customer.item')->with('success', 'Berhasil memilih metode pembayaran, paket anda akan segera diproses');
        }

        $image = $request->file('proof');
        if ($image) {
            $item->update([
                'proof' => $this->saveImage($image),
                'status' => 'paid',
            ]);
            return redirect()->route('customer.item')->with('success', 'Berhasil memilih metode pembayaran, paket anda akan segera diproses');
        } else {
            return redirect()->route('customer.item')->with('error', 'Gagal melakukan pembayaran, silahkan unggah bukti pembayaran!');
        }
    }

    private function saveImage($image)
    {
        $image_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path(self::PATH), $image_name);
        return $image_name;
    }

    private function checkPayment(Request $request)
    {
        if ($request->payment) {
            return true;
        } else {
            return false;
        }
    }

    public function lacakPaket()
    {
        return view('customer.item.lacak-paket', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
            'items' => $this->getAllItemsLacak(),
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    public function lacakPaketResi(Request $request)
    {
        if ($this->validateSearchResi($request)) {
            return redirect()->route('customer.lacak-paket')->with('error', 'Resi tidak valid!');
        }

        $item = $this->getItemByResi($request->search);
        if (!$item) {
            return redirect()->route('customer.lacak-paket')->with('error', 'Resi tidak ditemukan!');
        }
        return view('customer.item.found-paket', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
            'item' => $item,
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    private function validateSearchResi(Request $request)
    {
        if (!$request->search) {
            return true;
        } else {
            return false;
        }
    }

    private function getItemByResi($resi)
    {
        $item = Item::with('trackingItems')
            ->where('resi', $resi)
            ->first();
        return $item;
    }

    public function riwayatPengiriman()
    {
        return view('customer.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'page' => 'Paket',
            'items' => $this->getItemHistory(),
            'pathItemController' => \App\Http\Controllers\ItemController::class,
        ]);
    }

    private function getItemHistory()
    {
        return Item::with('sender', 'receiver', 'bank')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'done')
            ->orWhere('status', 'canceled')
            ->orWhere('status', 'rejected')
            ->latest()
            ->get();
    }

    private function validateSelf()
    {
        if (auth()->user()->profile->phone_number && auth()->user()->profile->address) {
            return true;
        } else {
            return false;
        }
    }

    private function validateSender(Request $request)
    {
        $this->validate($request, [
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:255',
            'sender_address' => 'required|string|max:255',
        ], [
            'sender_name.required' => 'Nama pengirim tidak boleh kosong',
            'sender_name.string' => 'Nama pengirim harus berupa string',
            'sender_name.max' => 'Nama pengirim maksimal 255 karakter',
            'sender_phone.required' => 'Nomor telepon pengirim tidak boleh kosong',
            'sender_phone.string' => 'Nomor telepon pengirim harus berupa string',
            'sender_phone.max' => 'Nomor telepon pengirim maksimal 255 karakter',
            'sender_address.required' => 'Alamat pengirim tidak boleh kosong',
            'sender_address.string' => 'Alamat pengirim harus berupa string',
            'sender_address.max' => 'Alamat pengirim maksimal 255 karakter',
        ]);
    }

    private function validateReceiver(Request $request)
    {
        $this->validate($request, [
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
        ], [
            'receiver_name.required' => 'Nama penerima tidak boleh kosong',
            'receiver_name.string' => 'Nama penerima harus berupa string',
            'receiver_name.max' => 'Nama penerima maksimal 255 karakter',
            'receiver_phone.required' => 'Nomor telepon penerima tidak boleh kosong',
            'receiver_phone.string' => 'Nomor telepon penerima harus berupa string',
            'receiver_phone.max' => 'Nomor telepon penerima maksimal 255 karakter',
            'receiver_address.required' => 'Alamat penerima tidak boleh kosong',
            'receiver_address.string' => 'Alamat penerima harus berupa string',
            'receiver_address.max' => 'Alamat penerima maksimal 255 karakter',
        ]);
    }

    private function validateItem(Request $request)
    {
        $this->validate($request, [
            'weight' => 'required',
        ], [
            'weight.required' => 'Berat barang tidak boleh kosong',
        ]);
    }

    private function getFirstBank()
    {
        $bank = Bank::first();
        return $bank;
    }

    private function getAllItems()
    {
        $items = Item::with('sender', 'receiver', 'bank')
            ->where('status', 'request')
            ->orWhere('status', 'accepted')
            ->orWhere('status', 'ok')
            ->orWhere('status', 'paid')
            ->latest()
            ->get();
        $items = $items->filter(function ($item) {
            return $item->user_id == auth()->user()->id;
        });
        return $items;
    }

    private function getAllItemsLacak()
    {
        return Item::with('sender', 'receiver', 'bank')
            ->where('user_id', auth()->user()->id)
            ->where('status', 'process')
            ->latest()
            ->get();
    }

    public function getAllBanksAgent($bank_id)
    {
        $user_id = Bank::find($bank_id)->user_id;
        $user = User::find($user_id);
        $banks = $user->banks;
        return $banks;
    }
}