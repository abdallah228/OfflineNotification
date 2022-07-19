
<form action="{{ route('posts.store') }}" method="post">
    @csrf

   Name <input type="text" name="title"><br>
   body <input type="text" name="body"><br>
    <input type="submit"  value="add post">
</form>

