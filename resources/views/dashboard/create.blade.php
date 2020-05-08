<h1>Create a new Post</h1>
<form method="POST" action="/dashboard/create">
    @csrf
    Post Title: <input type="text" name="title" /><br><br>
    Post Description: <br><textarea name="description" cols="30" rows="3"></textarea>
    <br><br>

    <button type="submit">Submit</button>
</form>
