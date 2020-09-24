<?php


namespace App\Repositories\Contracts;


interface IRepository
{
    public function entity();

    public function resolveEntity();
}
