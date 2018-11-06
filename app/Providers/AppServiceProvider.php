<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view) {
            $view->with('getAllUsers', $this->getAllUsers());
            $view->with('getAllDepartments', $this->getAllDepartments());
            $view->with('getAllPatients', $this->getAllPatients());
            $view->with('getAllDoctors', $this->getAllDoctors());
            $view->with('getAllPatientToday', $this->getAllPatientToday());
            $view->with('getAllRefundedPatient', $this->getAllRefundedPatient());

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function getAllUsers()
    {
        return DB::table('users')
            ->count();
    }

    public function getAllDepartments()
    {
        return DB::table('departments')
            ->count();
    }

    public function getAllPatients()
    {
        return DB::table('patients')
            ->where('patient_type', '!=', '')
            ->count();
    }


    public function getAllDoctors()
    {
        return DB::table('doctors')
            ->count();
    }


    public function getAllPatientToday()
    {
        return DB::table('patients')
            ->where('patient_type', '!=', '')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->count();
    }

    public function getAllRefundedPatient()
    {
        return DB::table('patients')
            ->where('patient_type', '!=', '')
            ->where('status', 'Inactive')
            ->count();
    }


}
