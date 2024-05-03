<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function subscribeToPlan(Request $request)
    {
        $user = auth()->user(); // Получаем текущего пользователя

        if ($user && $request->query('plan')) {
            // Создаем запись в таблице invoices
            $invoice = new Invoice();
            $invoice->user_id = $user->id;
            $invoice->inv_id = rand(10, 10000);
            //$invoice->tariff_id = $tariff->id;
            $invoice->tariff_name = $request->query('plan');
            $invoice->gpt3_tokens = 2000000;
            $invoice->gpt4_tokens = 800000;
            $invoice->tariff_expiry_date = now()->addMonth(); // Например, тариф действует месяц
            $invoice->save();

            return response()->json(['message' => 'Тариф успешно подключен'], 200);
        }

        return response()->json(['message' => 'Ошибка при подключении тарифа'], 400);
    }
}
