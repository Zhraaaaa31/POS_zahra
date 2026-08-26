<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function delete(User $user, Penjualan $penjualan): bool
    {
        return $user->role->name === 'admin'
         && $penjualan->status === 'OPEN';
    }

    public function view(User $user, Penjualan $penjualan): bool
    {
        //  return $user->role->name === 'admin'
        //  && $penjualan->status === 'OPEN';
        // Admin bisa lihat semua transaksi
    if ($user->role->name === 'admin') {
        return true;
    }

    // Kasir hanya bisa lihat transaksi miliknya sendiri
    return $user->id === $penjualan->user_id;
    }
}
