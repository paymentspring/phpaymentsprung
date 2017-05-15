@extends ('layout')

@section ('content')
  <h1>Search for Customers</h1>
  <form action="search" method="post" class="form-group">
    {{ csrf_field() }}
    <input type="text" name="search_term" placeholder="Customer ID, name, or company" class="form-control">
    <input type="submit" value="search" class="btn btn-default">
  </form>
@endsection