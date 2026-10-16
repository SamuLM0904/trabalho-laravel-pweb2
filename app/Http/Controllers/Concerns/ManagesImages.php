<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

trait ManagesImages
{
    protected function storeImage(Request $request, string $directory): ?string
    {
        if (!$request->hasFile('imagem')) {
            return null;
        }

        $path = $request->file('imagem')->store($directory, 'public');

        if ($path === false) {
            throw new RuntimeException('Não foi possível salvar a imagem enviada.');
        }

        return $path;
    }

    protected function deleteImage(?string $path): void
    {
        $disk = Storage::disk('public');

        if ($path && $disk->exists($path) && !$disk->delete($path)) {
            throw new RuntimeException('Não foi possível remover a imagem armazenada.');
        }
    }
}
