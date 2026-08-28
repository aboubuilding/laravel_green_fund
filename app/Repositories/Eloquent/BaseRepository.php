<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Types\TypeEtat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct()
    {
        $this->model = app($this->model());
    }

    /**
     * Définir le modèle
     */
    abstract public function model(): string;

    /**
     * {@inheritdoc}
     */
    public function all(): Collection
    {
        return $this->model->where('etat', TypeEtat::ACTIF)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): ?Model
    {
        return $this->model->where('etat', TypeEtat::ACTIF)->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data): Model
    {
        $data['etat'] = TypeEtat::ACTIF;
        return $this->model->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->find($id);
        if (!$model) {
            throw new \Exception('Model not found');
        }
        $model->update($data);
        return $model->fresh();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): bool
    {
        $model = $this->find($id);
        if (!$model) {
            return false;
        }
        return $model->update(['etat' => TypeEtat::SUPPRIME]);
    }
}
