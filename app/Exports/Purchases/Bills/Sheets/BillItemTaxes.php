<?php

namespace App\Exports\Purchases\Bills\Sheets;

use App\Abstracts\Export;
use App\Models\Document\DocumentItemTax as Model;
use App\Interfaces\Export\WithParentSheet;

class BillItemTaxes extends Export implements WithParentSheet
{
    public function collection()
    {
        return Model::with('document', 'item', 'tax')->bill()->collectForExport($this->ids, null, 'document_id');
    }

    public function map($model): array
    {
        $document = $model->document;

        if (empty($document)) {
            return [];
        }

        $model->bill_number = $document->document_number;
        $model->item_name = $model->item->name;
        $model->tax_name = $model->tax->name;
        $model->tax_rate = $model->tax->rate;

        return parent::map($model);
    }

    public function fields(): array
    {
        return [
            'bill_number',
            'item_name',
            'tax_name',
            'tax_rate',
            'amount',
        ];
    }
}
