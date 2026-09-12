@extends('layouts.master')

@section('title', 'Add Medical Record - PetCare')
@section('body-class', 'medical-record-page')

@push('styles')
    <style>
        .medical-record-page .main-content {
            background-color: #f4f6f4;
        }

        .record-form-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px 80px;
            min-height: calc(100vh - 90px);
        }

        .record-box {
            width: 100%;
            max-width: 760px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0,0,0,0.04);
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
        }

        .record-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 30px;
            border-bottom: 1px solid #eef2eb;
            background-color: #fafbf9;
        }

        .record-header-content {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .record-icon {
            font-size: 22px;
            color: #2f7d47;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #e8f5e9;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .record-header-text h2 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 2px;
            color: #1f2b23;
        }

        .record-header-text p {
            margin: 0;
            font-size: 13px;
            color: #64748b;
        }

        .record-close-btn {
            border: none;
            background-color: transparent;
            color: #64748b;
            font-size: 18px;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .record-close-btn:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .record-form-body {
            padding: 28px 30px;
        }

        .form-row-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 22px;
        }

        .form-row-three {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        .form-field {
            margin-bottom: 22px;
        }

        .form-field label {
            display: block;
            font-size: 13.5px;
            font-weight: 600;
            color: #334138;
            margin-bottom: 8px;
        }

        .form-field .required-star {
            color: #e11d48;
        }

        .record-input,
        .record-select,
        .record-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14.5px;
            color: #1e293b;
            background-color: #ffffff;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            font-family: inherit;
        }

        .record-input,
        .record-select {
            height: 46px;
        }

        .record-textarea {
            min-height: 95px;
            resize: vertical;
        }

        .record-input:focus,
        .record-select:focus,
        .record-textarea:focus {
            border-color: #2f7d47;
            box-shadow: 0 0 0 3px rgba(47, 125, 71, 0.12);
        }

        .file-upload-box {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background-color: #f8faf8;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .file-upload-box:hover {
            border-color: #2f7d47;
            background-color: #f0fdf4;
        }

        .file-upload-box input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .file-upload-icon {
            font-size: 28px;
            color: #2f7d47;
        }

        .file-upload-text {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }

        .file-upload-hint {
            font-size: 12px;
            color: #64748b;
            margin: 0;
        }

        .file-chosen-name {
            font-size: 13px;
            font-weight: 600;
            color: #2f7d47;
            margin-top: 6px;
            display: none;
        }

        .internal-notes-box {
            background-color: #f8faf8;
            border: 1px dashed #cbd5e1;
            min-height: 75px;
        }

        .internal-notes-box:focus {
            background-color: #ffffff;
        }

        .internal-label {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
        }

        .record-footer {
            padding: 18px 30px;
            border-top: 1px solid #eef2eb;
            background-color: #fafbf9;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
        }

        .record-btn {
            height: 44px;
            border-radius: 10px;
            padding: 0 22px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }

        .record-btn-cancel {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .record-btn-cancel:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .record-btn-save {
            border: none;
            background-color: #2f7d47;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(47,125,71,0.25);
        }

        .record-btn-save:hover {
            background-color: #236337;
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .form-row-two, .form-row-three {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .record-form-body {
                padding: 20px 18px;
            }
            .record-header {
                padding: 18px 20px;
            }
            .record-footer {
                padding: 16px 20px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="main-content">
        <div class="record-form-wrapper">
            <div class="record-box">

                <!-- Header -->
                <div class="record-header">
                    <div class="record-header-content">
                        <div class="record-icon">
                            <i class="fa-solid fa-kit-medical"></i>
                        </div>
                        <div class="record-header-text">
                            <h2>Add Medical Report</h2>
                            <p>Record medical diagnosis, treatment plan, and upload attachments to DB.</p>
                        </div>
                    </div>

                    <a href="{{ route('medical_history', $selected_pet_id ?? '') }}" class="record-close-btn" title="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('medical_record.save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="record-form-body">

                        @if (isset($errors) && $errors->any())
                            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px;">
                                <ul style="margin: 0; padding-left: 18px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Row 1: Patient and Date -->
                        <div class="form-row-two">
                            <div class="form-field" style="margin-bottom: 0;">
                                <label for="select-pet">Select Patient <span class="required-star">*</span></label>
                                <select name="Pets" id="select-pet" class="record-select" required>
                                    <option value="" disabled {{ empty($selected_pet_id) ? 'selected' : '' }}>Choose a pet...</option>
                                    @if (isset($pets) && count($pets) > 0)
                                        @foreach ($pets as $pet)
                                            <option value="{{ $pet->id }}" {{ (isset($selected_pet_id) && ($selected_pet_id == $pet->id || $selected_pet_id == $pet->name)) ? 'selected' : '' }}>
                                                {{ $pet->name }} ({{ $pet->type ?? 'Pet' }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="1" selected>Bella (Golden Retriever)</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-field" style="margin-bottom: 0;">
                                <label for="date">Visit Date <span class="required-star">*</span></label>
                                <input type="date" name="visit_date" class="record-input" id="date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <!-- Row 2: Report Type, Title, and Weight -->
                        <div class="form-row-three">
                            <div class="form-field" style="margin-bottom: 0;">
                                <label for="report-type">Report Type</label>
                                <select name="type" id="report-type" class="record-select">
                                    <option value="Routine Checkup" selected>Routine Checkup</option>
                                    <option value="Sick Visit">Sick Visit</option>
                                    <option value="Vaccination">Vaccination</option>
                                    <option value="Surgery">Surgery</option>
                                    <option value="Dental Care">Dental Care</option>
                                    <option value="Lab & Blood Test">Lab &amp; Blood Test</option>
                                    <option value="Emergency">Emergency</option>
                                </select>
                            </div>

                            <div class="form-field" style="margin-bottom: 0;">
                                <label for="report-title">Report Title</label>
                                <input type="text" name="title" id="report-title" class="record-input" placeholder="e.g. Annual Booster & Checkup">
                            </div>

                            <div class="form-field" style="margin-bottom: 0;">
                                <label for="pet-weight">Pet Weight (kg)</label>
                                <input type="text" name="weight" id="pet-weight" class="record-input" placeholder="e.g. 28.5">
                            </div>
                        </div>

                        <!-- Row 3: Diagnosis -->
                        <div class="form-field">
                            <label for="describe">Diagnosis / Clinical Findings <span class="required-star">*</span></label>
                            <textarea id="describe" name="describe" class="record-textarea" placeholder="Enter clinical observations, physical exam results, symptoms, and diagnosis..." required></textarea>
                        </div>

                        <!-- Row 4: Treatment Plan -->
                        <div class="form-field">
                            <label for="treat-plan">Treatment Plan &amp; Prescriptions</label>
                            <textarea id="treat-plan" name="treat_plan" class="record-textarea" placeholder="Prescribed medications, dosage, diet, recovery instructions, or follow-up procedures..."></textarea>
                        </div>

                        <!-- Row 5: Report File Upload (PDF, Image, Doc) -->
                        <div class="form-field">
                            <label>Attach Medical Report / Document (PDF, Image, DOC)</label>
                            <div class="file-upload-box" onclick="document.getElementById('report-file-input').click();">
                                <input type="file" name="report_file" id="report-file-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" onchange="displayFileName(this)">
                                <div class="file-upload-content">
                                    <i class="fa-solid fa-cloud-arrow-up file-upload-icon"></i>
                                    <p class="file-upload-text">Click to upload report file or drag &amp; drop</p>
                                    <p class="file-upload-hint">PDF, DOCX, PNG, JPG up to 10MB</p>
                                    <div id="file-chosen-display" class="file-chosen-name"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 6: Internal Notes -->
                        <div class="form-field" style="margin-bottom: 0;">
                            <label class="internal-label" for="notes">
                                <i class="fa-solid fa-lock"></i>
                                Internal Staff Notes (Confidential)
                            </label>
                            <textarea id="notes" name="notes" class="record-textarea internal-notes-box" placeholder="Internal observations for clinic team only..."></textarea>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="record-footer">
                        <a href="{{ route('medical_history', $selected_pet_id ?? '') }}" class="record-btn record-btn-cancel">
                            Cancel
                        </a>
                        <button type="submit" name="save" class="record-btn record-btn-save">
                            <i class="fa-regular fa-floppy-disk"></i>
                            Save to Database &amp; Notify Owner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function displayFileName(input) {
            const display = document.getElementById('file-chosen-display');
            if (input.files && input.files[0]) {
                display.innerText = 'Selected file: ' + input.files[0].name;
                display.style.display = 'block';
            } else {
                display.innerText = '';
                display.style.display = 'none';
            }
        }
    </script>
@endsection
