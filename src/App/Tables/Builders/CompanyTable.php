<?php

namespace LaravelEnso\Companies\App\Tables\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use LaravelEnso\Companies\App\Models\Company;
use LaravelEnso\Tables\App\Contracts\Table;

class CompanyTable implements Table
{
    protected const TemplatePath = __DIR__.'/../Templates/companies.json';

    public function query(): Builder
    {

//        For Admin
        if (Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'super'){

            return Company::selectRaw('
            companies.id, companies.code, companies.name,  people.name as mandatary,
            companies.email,
            companies.phone,  companies.status, companies.status as statusValue,
            companies.is_tenant, companies.created_at
            ')->leftjoin(
                'company_person',
                fn ($join) => $join
                    ->on('companies.id', '=', 'company_person.company_id')
                    ->where('company_person.is_mandatary', true)
            )->leftJoin('people', 'company_person.person_id', '=', 'people.id');

        }

//        For Campus Head
        elseif (Auth::user()->role->name == 'campus_head'){

            $person_id = Auth::user()->person_id;
            return Company::selectRaw('
            companies.id, companies.code, companies.name,  people.name as mandatary,
            companies.email,
            companies.phone,  companies.status, companies.status as statusValue,
            companies.is_tenant, companies.created_at
            ')->join(
                'company_person',
                fn ($join) => $join
                    ->on('companies.id', '=', 'company_person.company_id')
                    ->where('company_person.is_mandatary', true)->where('company_person.person_id', '=', $person_id)
            )->leftJoin('people', 'company_person.person_id', '=', 'people.id');

        }




    }

    public function templatePath(): string
    {
        return static::TemplatePath;
    }
}
