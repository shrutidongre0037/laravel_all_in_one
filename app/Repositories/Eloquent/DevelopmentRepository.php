<?php

namespace App\Repositories\Eloquent;

use App\Models\Development;
use App\Repositories\Interfaces\DevelopmentRepositoryInterface;
use Illuminate\Support\Facades\Storage;


class DevelopmentRepository implements DevelopmentRepositoryInterface
{
    public function all()
    {
        return Development::all();
    }

    public function find($id)
    {
        return Development::with(['department', 'projects'])->findOrFail($id);
    }

    public function create(array $data)
    {
        $development = Development::create($data);

        if (isset($data['project_ids'])) {
            $development->projects()->sync($data['project_ids']);
        }

        return $development;
    }

    public function update($id, array $data)
    {
        $development = Development::findOrFail($id);

        // Handle image if present
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old image
            if ($development->image) {
                Storage::delete('public/developments/' . $development->image);
            }

            // Upload new image
            $data['image'] = $data['image']->store('developments', 'public');
        }

        $development->fill($data)->save();
        $this->syncProjects($development, $data);

        return $development;
    }

    private function syncProjects(Development $development, array $data): void
    {
        if (!empty($data['project_ids'])) {
            $development->projects()->sync($data['project_ids']);
        }
    }

    public function delete($id)
    {
        return Development::findOrFail($id)->delete();
    }

    public function restore($id)
    {
        return Development::onlyTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete($id)
    {
        return Development::withTrashed()->findOrFail($id)->forceDelete();
    }
}
