<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrations {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Migrtions Tenants';

    /**
     That variable manager conections.
     * @var ManagerTenant
     */
    private $tenant;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $id                = $this->argument('id');
        $commandInstall    = $this->option('refresh') ? 'migrate:refresh' : 'migrate:install';
        $commandDatabase   = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        if ($id) {
            $company = Company::find($id);
            if ($company) {
                $this->execCommand( $company,  $commandInstall,  $commandDatabase );
            }

            return;
        }

        $campanies = Company::all();
        foreach ($campanies as $company){
            $this->execCommand( $company,  $commandInstall,  $commandDatabase );
        }

    }

    private function execCommand(Company $company, string $commandInstall,  string $commandDatabase )
    {
        $this->tenant->setConnection($company);
        $this->info("Connecting Company {$company->name}");

        Artisan::call($commandInstall, [
            '--database' => 'tenant'
        ]);

        Artisan::call($commandDatabase, [
            '--force' => true,
            '--path' => '/database/migrations/tenant'
        ]);

        $this->info("End Connecting Company {$company->name}");
        $this->info("---------------------------------");
    }


}
