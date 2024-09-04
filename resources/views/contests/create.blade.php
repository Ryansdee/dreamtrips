<title>create | Dream Trips</title>
<x-app-layout>
<div class="container">
    <h1>Create a New Contest</h1>
    <form method="POST" action="{{ route('contests.store') }}">
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
            <label for="entry_fee">Entry Fee</label>
            <input type="image" name="entry_fee" id="entry_fee" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Contest</button>
    </form>
</div>
    </x-app-layout>
