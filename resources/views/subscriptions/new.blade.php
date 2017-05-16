@extends ('layout')

@section ('content')
  <h1>Create a subscription</h1>
  <form action="/subscriptions/new" method="post" class="form-group">
    {{ csrf_field() }}
    <input type="text" name="id" placeholder="Plan ID" class="form-control">
    <input type="text" name="customer_id" placeholder="Customer ID" class="form-control">
    <input type="text" name="ends_after" placeholder="Number of billings" class="form-control">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
@endsection
