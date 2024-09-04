<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<title>Create | Dream Trips</title>
<x-app-layout>
<div class="container" style="margin-top: 1rem">
    <h1>Create a New Contest</h1>
    <form method="POST" action="{{ route('contests.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Contest Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="entry_fee">Entry Fee</label>
            <input type="number" name="entry_fee" id="entry_fee" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="images">Contest Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple style="border: 1px solid black; border-radius: 10px">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 1rem">Create Contest</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</x-app-layout>
