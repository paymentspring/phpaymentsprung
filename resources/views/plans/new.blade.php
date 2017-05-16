@extends ('layout')

@section ('content')
  <h1>Create a plan</h1>
  <form action="/plans" method="post" class="form-group">
    {{ csrf_field() }}
    <select name="frequency" class="form-control">
      <option value="daily">Daily</option>
      <option value="weekly">Weekly</option>
      <option value="monthly">Monthly</option>
      <option value="quarterly">Quarterly</option>
      <option value="yearly">Yearly</option>
    </select>
    <input type="text" name="name" placeholder="Name of plan" class="form-control">
    <input type="text" name="amount" placeholder="00.00" class="form-control">
    <input type="text" name="day" placeholder="Day" class="form-control">
    <input type="submit" value="submit" class="btn btn-default">
  </form>
@endsection
