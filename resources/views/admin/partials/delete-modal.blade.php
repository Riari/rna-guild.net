@include('partials.delete-modal', ['id' => $id, 'action' => route('admin.resource.delete', compact('model', 'model_id'))])
