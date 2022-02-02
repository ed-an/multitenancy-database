<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CompanyCreated;
use App\Events\Tenant\DatabaseCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreUpdateCompanyFormRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource
     * @return  \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->company->latest()->paginate();

        return view('tenants.companies.index', compact('companies'));
    }

    /**
     *  Show the form for creating a new resource
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tenants.companies.create', ['company' => new Company()]);
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreUpdateCompanyFormRequest
     * @return  \Illuminate\Http\Response
     */
    public function store(StoreUpdateCompanyFormRequest $request)
    {

        dd($request);
        $company = $this->company->create($request->all());
        /*
        $value = Str::random(5);
        $company = $this->company->create([
            'name'        => 'Empresa x' . $value,
            'domain'      =>  $value .'minhaempresa.com',
            'bd_database' => 'databasex' . $value,
            'bd_host'     => 'mysql',
            'bd_username' => 'root',
            'bd_password' => 'root'
        ]);
        */
        if ($request->has('create_database')) {
            event(new CompanyCreated($company));
        } else {
            event(new DatabaseCreated($company));
        }

        return redirect()
            ->route('company.index')
            ->withSuccess('Cadastro realizado com sucesso');
    }

    /**
     * @param string $domain
     * @return  \Illuminate\Http\Response
     */
    public function show($domain)
    {
        $company = $this->company->where('domain', $domain)->first();
        if (!$company) {
            return redirect()->back();
        }

        return view('tenants.companies.index', compact('company'));
    }

    /**
     * @param $domain
     * @return  \Illuminate\Http\Response
     */
    public function edit($domain)
    {
        $company = $this->company->where('domain', $domain)->first();
        if (!$company) {
            return redirect()->back();
        }
        return view('tenants.companies.index', compact('company'));
    }

    /**
     * Updated the specified  resource in storage.
     * @param StoreUpdateCompanyFormRequest
     * @param $id
     * @return  \Illuminate\Http\Response
     */
    public function update(StoreUpdateCompanyFormRequest $request, $id)
    {
        if(!$company = $this->company->find($id)){
            return redirect()->back()->withInput();
        }

        $company->update($request->all());

        return redirect()
            ->route('company.index')
            ->withSuccess('Cadastro atualizado com sucesso');
    }

    /**
     * Remove the specified resource in storage
     * @param $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$company = $this->company->find($id)){
            return redirect()->back()->withInput();
        }

        $company->delete();

        return redirect()
            ->route('company.index')
            ->withSuccess('Cadastro atualizado com sucesso');
    }
}
