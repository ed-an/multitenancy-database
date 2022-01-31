<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function store(Request $request)
    {

        $value = Str::random(5);
        $company = $this->company->create([
            'name'        => 'Empresa x' . $value,
            'domain'      =>  $value .'minhaempresa.com',
            'bd_database' => 'databasex' . $value,
            'bd_host'     => 'mysql',
            'bd_username' => 'root',
            'bd_password' => 'root'
        ]);

        event(new CompanyCreated($company));
        dd($company);
    }
}
