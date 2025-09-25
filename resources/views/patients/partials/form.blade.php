<div class="mb-3">
  <label>Name</label>
  <input type="text" name="name" class="form-control" 
         value="{{ old('name', $patient->name ?? '') }}" required>
</div>

<div class="mb-3">
  <label>Email</label>
  <input type="email" name="email" class="form-control" 
         value="{{ old('email', $patient->email ?? '') }}" required>
</div>

<div class="mb-3">
  <label>Phone</label>
  <input type="text" name="phone" class="form-control" 
         value="{{ old('phone', $patient->phone ?? '') }}">
</div>

<div class="mb-3">
  <label>Address</label>
  <input type="text" name="address" class="form-control" 
         value="{{ old('address', $patient->address ?? '') }}">
</div>

<div class="mb-3">
  <label>Date of Birth</label>
  <input type="date" name="date_of_birth" class="form-control" 
         value="{{ old('date_of_birth', $patient->date_of_birth ?? '') }}">
</div>

<div class="mb-3">
  <label>Gender</label>
  <select name="gender" class="form-control">
    <option value="">-- Select --</option>
    <option value="Male" {{ old('gender', $patient->gender ?? '')=='Male' ? 'selected' : '' }}>Male</option>
    <option value="Female" {{ old('gender', $patient->gender ?? '')=='Female' ? 'selected' : '' }}>Female</option>
    <option value="Other" {{ old('gender', $patient->gender ?? '')=='Other' ? 'selected' : '' }}>Other</option>
  </select>
</div>

<div class="mb-3">
  <label>Medical History</label>
  <textarea name="medical_history" class="form-control">{{ old('medical_history', $patient->medical_history ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-success">{{ $submitText }}</button>
<a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
