<div class="form-group">
    <label>{{ __('Nama role') }}</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $role->name) }}">
    @error('name')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
<div class="form-group">
    <label>{{ __('Guard name') }}</label>
    <input type="text" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror" value="web"
        readonly>
    @error('guard_name')
    <small class="invalid-feedback" role="alert">{{ $message }}</small>
    @enderror
</div>
<div class="form-group">
    <label>Permission</label>
    <select class="form-control select2" multiple="multiple" data-placeholder="Select a Permission" style="width: 100%;" name="permissions[]">
        @foreach ($permission as $item)
            <option value="{{$item->name}}" {{is_array($permissionselected) && in_array($item->name, $permissionselected) ? 'selected' : '' }}>{{$item->name}}</option>
        @endforeach
    </select>
  </div>
