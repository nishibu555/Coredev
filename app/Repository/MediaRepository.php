<?php


namespace App\Repository;


use App\Models\Media;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Repository\Repository;

class MediaRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Media::class;
    }

    public function storeMany(array $medias, Model $model, string $type): Collection
    {
        $modelName = get_class($model);
        $modelBaseName = strtolower(class_basename($modelName));
        $mediaCollection = collect();

        foreach ($medias as $key => $file) {
            $extension = $file->getClientOriginalExtension();
            $path = $file->storeAs("{$modelBaseName}s/{$model->id}", time() . "." . $extension);

            if (!$path) {
                continue;
            }

            $media = $this::create(
                [
                    'type' => $type,
                    'name' => $modelBaseName . '_' . $model->id,
                    'src' => "/{$path}",
                    'path' => "/{$path}",
                    'extension' => $extension,
                    'description' => "This is {$type} for {$modelName} {$model->id}",
                    'mediable_type' => $modelName,
                    'mediable_id' => $model->id
                ]);

            $mediaCollection->push($media);
        }

        return $mediaCollection;
    }

    private function findByMediable($mediableType, $mediableId)
    {
        return $this->model()::where('mediable_id', $mediableId)
            ->where('mediable_type', $mediableType);
    }

    public function findById($mediableType, $mediableId, $mediaId)
    {
        $this->findByMediable($mediableType, $mediableId)->findOrFail($mediaId);
    }

}
