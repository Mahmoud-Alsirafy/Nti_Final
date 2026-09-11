@extends('layouts.master')

@section('title', 'Add Medical Record - PetCare')
@section('body-class', 'medical-record-page')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
@endpush

@section('content')
    <main class="main-content">
        <div style="display: flex; justify-content: center; align-items: flex-start; padding: 40px 20px; min-height: calc(100vh - 90px); background: #f4f6f4;">
            <div class="box">

                <div class="header">
                    <div class="header-content">
                        <div class="icon">
                            <i class="fa-solid fa-kit-medical"></i>
                        </div>

                        <div class="header-text">
                            <h2>Add Medical Record</h2>
                            <p>Log details for the recent visit.</p>
                        </div>
                    </div>

                    <a href="{{ route('medical_history') }}" class="close-btn" style="text-decoration: none;" title="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>

                <form method="POST" action="{{ route('medical_record.save') }}">
                    @csrf
                    <div class="form-group">
                        <div class="form-head">
                            <div class="form-body">
                                <label for="select-pet">Select Patient</label>
                                <select name="Pets" id="select-pet">
                                    <option value="" disabled selected>Choose a pet...</option>
                                    @if (isset($pets) && count($pets) > 0)
                                        @foreach ($pets as $pet)
                                            <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->type ?? 'Pet' }})</option>
                                        @endforeach
                                    @else
                                        <option value="Bella" selected>Bella (Golden Retriever)</option>
                                        <option value="Oliver">Oliver (Tabby Cat)</option>
                                        <option value="Semba">Semba (Tabby Cat)</option>
                                        <option value="Max">Max (German Shepherd)</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-body">
                                <label for="date">Visit Date</label>
                                <input type="date" name="visit_date" class="in-date" id="date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="form-body">
                            <label for="describe">Diagnosis / Primary Notes <span class="required">*</span></label>
                            <textarea id="describe" name="describe" placeholder="Enter main findings and observations..." required></textarea>
                        </div>

                        <div class="form-body">
                            <label for="treat-plan">Treatment Plan</label>
                            <textarea id="treat-plan" name="treat_plan" placeholder="Prescriptions, procedures, or next steps..."></textarea>
                        </div>

                        <div class="form-body">
                            <label class="internal-label" for="notes">
                                <i class="fa-solid fa-lock"></i>
                                Internal Notes (Not shared with client)
                            </label>
                            <textarea id="notes" name="notes" placeholder="Staff-only observations" class="internal-notes"></textarea>
                        </div>
                    </div>

                    <div class="form-footer">
                        <a href="{{ route('medical_history') }}" class="btn cancel-btn" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                            Cancel
                        </a>
                        <button type="submit" name="save" class="btn save-btn">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Save Medical Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
@endpush
