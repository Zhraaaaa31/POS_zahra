<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    public function delete(User $user, Penjualan $penjualan): bool
    {
        return $user->role->name === 'admin'
         && $penjualan->status === 'OPEN';
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        // Admin bisa lihat semua transaksi
        if ($user->role->name === 'admin') {
            return true;
        }

        // Kasir hanya bisa lihat transaksi miliknya sendiri
        return $user->id === $penjualan->user_id;
    }

    public function update(User $user, Penjualan $penjualan): bool
    {
        // Transaksi yang sudah COMPLETED tidak boleh diedit lagi
        if ($penjualan->status !== 'OPEN') {
            return false;
        }

        // Admin boleh mengedit transaksi OPEN siapa saja
        if ($user->role->name === 'admin') {
            return true;
        }

        // Kasir hanya boleh mengedit transaksi OPEN miliknya sendiri
        return $user->id === $penjualan->user_id;
    }
}