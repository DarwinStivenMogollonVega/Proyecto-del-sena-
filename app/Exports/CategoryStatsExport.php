<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CategoryStatsExport implements FromArray, WithHeadings, ShouldAutoSize, WithEvents
{
    private array $rows;
    private int $columnCount;

    public function __construct(
        private readonly array $headings,
        array $rows
    ) {
        $this->columnCount = max(1, count($this->headings));

        // Normaliza cada fila para mantener el mismo numero de columnas que el encabezado.
        $this->rows = array_map(function ($row): array {
            if (!is_array($row)) {
                $row = (array) $row;
            }

            $values = array_values($row);
            $values = array_slice($values, 0, $this->columnCount);

            if (count($values) < $this->columnCount) {
                $values = array_pad($values, $this->columnCount, '');
            }

            return $values;
        }, $rows);

        if ($this->rows === []) {
            $this->rows[] = array_merge(
                ['Sin datos disponibles'],
                array_fill(0, $this->columnCount - 1, '')
            );
        }
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event): void {
                $sheet = $event->sheet->getDelegate();
                $lastColumn = $sheet->getHighestColumn();
                $lastRow = max(1, count($this->rows) + 1);

                $headerRange = 'A1:' . $lastColumn . '1';
                $tableRange = 'A1:' . $lastColumn . $lastRow;

                $sheet->freezePane('A2');
                $sheet->setAutoFilter($headerRange);

                // Encabezado con estilo visible.
                $sheet->getStyle($headerRange)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF1D4ED8'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Bordes para que se vea como tabla.
                $sheet->getStyle($tableRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Alineación de datos (izquierda) para legibilidad.
                if ($lastRow > 1) {
                    $sheet->getStyle('A2:' . $lastColumn . $lastRow)->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_LEFT);
                }

                // Alto mínimo del encabezado.
                $sheet->getRowDimension(1)->setRowHeight(22);
            },
        ];
    }
}
