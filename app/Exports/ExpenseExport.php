<?php

namespace App\Exports;

use App\Models\Book;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpenseExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        if ($from == null) {
            $this->from = \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'); // Tanggal 1 bulan ini
        } else {
            $this->from = $from;
        }

        if ($to == null) {
            $this->to = \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d'); // Tanggal terakhir bulan ini
        } else {
            $this->to = $to;
        }
    }

    public function query()
    {
        $data = Transaction::whereBetween('transactions.date', [$this->from, $this->to])
            ->selectRaw('transactions.transaction_no, transactions.transaction_type, transactions.amount')
            ->where('transactions.transaction_type', 'Bill')->orWhere('transactions.transaction_type', 'Paying');

        return $data;
    }

    public function headings(): array
    {
        $data = 'Laporan Uang Masuk AVour';

        return [[$data], ['Nomor Transaksi', 'Jenis Transaksi','Jumlah']];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Ambil baris terakhir berdasarkan data
                $lastRow = $sheet->getHighestRow() + 1;

                // Tambahkan label "Summary" di kolom A pada baris terakhir
                $sheet->setCellValue('A' . $lastRow, 'Summary');
                $sheet->mergeCells('A' . $lastRow . ':D' . $lastRow); // Menggabungkan kolom A sampai D untuk label
                $sheet
                    ->getStyle('A' . $lastRow)
                    ->getAlignment()
                    ->setHorizontal('right'); // Rata kanan

                // Tambahkan formula SUM untuk kolom jumlah (misal, kolom E)
                $sheet->setCellValue('E' . $lastRow, '=SUM(E3:E' . ($lastRow - 1) . ')');
                $sheet
                    ->getStyle('E' . $lastRow)
                    ->getFont()
                    ->setBold(true); // Buat teks total tebal

                // Format jumlah sebagai mata uang
                $sheet
                    ->getStyle('E3:E' . $lastRow)
                    ->getNumberFormat()
                    ->setFormatCode('#,##0.00'); // Format angka Indonesia
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.

            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
        ];
    }
    // public function id($id) {
    //     $this->id = $id;
    // }
    //     public function id_user($id_user) {
    //     $this->id = $id_user;
    // }
    //         public function from($from) {
    //     $this->id = $from;
    // }
    //             public function to($to) {
    //     $this->id = $to;
    // }

    // public function collection()
    // {
    //     return Book::whereBetween('book_date', [$this->from, $this->to])
    //         ->where('id_hotel', $this->id)
    //         ->where('id_user', $this->id_user)
    //         ->get();
    // }
}
