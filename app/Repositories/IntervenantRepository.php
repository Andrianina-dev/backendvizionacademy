<?php

namespace App\Repositories;

use App\Models\Intervenant;

class IntervenantRepository
{
    public function getAll()
    {
        return Intervenant::get();
    }

    public function getById(string $id)
    {
        return Intervenant::find($id);
    }

    public function create(array $data)
    {
        return Intervenant::create($data);
    }

    public function update(string $id, array $data)
    {
        $intervenant = Intervenant::find($id);
        if ($intervenant) {
            $intervenant->update($data);
            return $intervenant;
        }
        return null;
    }

    public function delete(string $id)
    {
        $intervenant = Intervenant::find($id);
        if ($intervenant) {
            return $intervenant->delete();
        }
        return false;
    }

   public function favorisParEcole($ecoleId)
{
    return Intervenant::whereHas('missions', function($q) use ($ecoleId) {
        $q->where('ecole_id', $ecoleId);
    })->get();
}


}
