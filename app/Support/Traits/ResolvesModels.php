<?php namespace App\Support\Traits;

trait ResolvesModels
{
    /**
     * Resolve a model by name and ID.
     *
     * @param  string  $name
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function resolve($name, $id)
    {
        $class = "\\App\\Models\\{$name}";
        return (new $class)->findOrFail($id);
    }
}
