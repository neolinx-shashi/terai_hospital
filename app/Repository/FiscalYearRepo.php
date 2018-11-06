<?php
/**
 * Created by PhpStorm.
 * User: ym-jenish
 * Date: 5/13/16
 * Time: 2:59 PM
 */

namespace App\Repository;


use App\Models\FiscalYear;

class FiscalYearRepo
{
    /**
     * @var FiscalYear
     */
    private $fiscalYear;

    public function __construct(FiscalYear $fiscalYear)
    {

        $this->fiscalYear = $fiscalYear;
    }

    public function all()
    {
        return $this->fiscalYear
            ->orderBy('id', 'DESC');
    }

    public function lists()
    {
        return $this->fiscalYear
            ->select('fiscal_year_nepali', 'id')
            ->orderBy('id', 'ASC')
            ->get();
    }

    public function currentFiscalYear()
    {
        return $this->fiscalYear
            ->where('current_fiscal_year', 'Y')
            ->first();
    }

    public function status($id)
    {
        $result = $this->fiscalYear
            ->where('id', $id)
            ->update(['current_fiscal_year'=> 'Y']);
        if($result) {
            return $this->fiscalYear
                ->where('id', '<>', $id)
                ->update(['current_fiscal_year' =>  'N']);
        }
        return $result;
    }
}