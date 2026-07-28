<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ItemPenjualan;

class ItemPenjualanPolicy
{
    public function delete(User $user, ItemPenjualan $itemPenjualan): bool
    {
        // Hanya Admin DAN transaksi statusnya OPEN
        return $user->role->name === 'admin' ;
    }
}