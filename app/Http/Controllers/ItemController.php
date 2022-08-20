<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Sender;
use App\Models\Receiver;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('customer.item.index', [
            'title' => 'Kirim Paket',
            'page' => 'Paket',
            'items' => $this->getAllItems(),
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

    public function lacakPaket()
    {
        return view('customer.item.lacak-paket', [
            'title' => 'Lacak Paket',
            'page' => 'Paket',
        ]);
    }

    public function riwayatPengiriman()
    {
        return view('customer.item.riwayat-pengiriman', [
            'title' => 'Riwayat Pengiriman',
            'page' => 'Paket',
        ]);
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
        return Item::whereNotIn('status', ['canceled', 'rejected'])
            ->latest()
            ->get();
    }
}