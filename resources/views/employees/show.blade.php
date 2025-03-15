@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Edit Employee</h2>
    <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <!-- Name (Auto-filled) -->
        <div>
            <label class="block font-medium">Name:</label>
            <input type="text" name="name" id="name" value="{{ $employee->name }}" class="w-full p-2 border rounded-md bg-gray-100" readonly>
        </div>

        <!-- Position -->
        <div>
            <label class="block font-medium">Posisi:</label>
            <select name="position" id="position" class="w-full p-2 border rounded-md">
                <option value="">Pilih Posisi</option>
                @foreach(['HR', 'Kepala Akuntan', 'Staff Akuntan', 'Kepala Admin', 'Staff Admin', 'Kepala Produksi', 'Staff Produksi', 'Kepala Operator dan Mekanik Alat Berat', 'Staff Operator dan Mekanik Alat Berat', 'Kepala Mekanik Mesin Silikas', 'Staff Mekanik Mesin Silikas', 'Kepala Gudang', 'Staff Gudang', 'Kepala Quality Control', 'Staff Quality Control'] as $pos)
                    <option value="{{ $pos }}" {{ $employee->position == $pos ? 'selected' : '' }}>{{ $pos }}</option>
                @endforeach
            </select>
        </div>

        <!-- Department (Readonly) -->
        <div>
            <label for="department" class="block font-medium text-gray-700">Department</label>
            <input type="text" id="department" name="department" value="{{ $employee->department }}" class="w-full p-2 border rounded-md bg-gray-100" readonly>
        </div>

        <!-- Manager -->
        <div>
            <label class="block font-medium">Manager:</label>
            <select name="manager" class="w-full p-2 border rounded-md">
                <option value="" {{ is_null($employee->manager) ? 'selected' : '' }}>-- Pilih Manager --</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->name }}" {{ $employee->manager == $manager->name ? 'selected' : '' }}>
                        {{ $manager->name }} - {{ $manager->position }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Employee Type -->
        <div>
            <label class="block font-medium">Employee Type:</label>
            <div class="flex space-x-4">
                @foreach(['Karyawan Tetap', 'Karyawan Kontrak', 'Magang'] as $type)
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="employee_type" value="{{ $type }}" {{ $employee->employee_type == $type ? 'checked' : '' }} class="form-radio">
                        <span>{{ $type }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Email & Phone Number -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium">Email:</label>
                <input type="email" name="email" id="email" value="{{ $employee->email }}" class="w-full p-2 border rounded-md bg-gray-100" readonly>
            </div>
            <div>
                <label class="block font-medium">Phone Number:</label>
                <input type="text" name="phone_number" value="{{ $employee->phone_number }}" class="w-full p-2 border rounded-md">
            </div>
        </div>

        <!-- KTP Number & Address -->
        <div>
            <label class="block font-medium">KTP Number:</label>
            <input type="text" name="ktp_number" value="{{ $employee->ktp_number }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">KTP Address:</label>
            <input type="text" name="ktp_address" value="{{ $employee->ktp_address }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">KTP City:</label>
            <input type="text" name="ktp_city" value="{{ $employee->ktp_city }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Domicile Address:</label>
            <input type="text" name="domicile_address" value="{{ $employee->domicile_address }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Domicile City:</label>
            <input type="text" name="domicile_city" value="{{ $employee->domicile_city }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Bank Account:</label>
            <input type="text" name="bank_account" value="{{ $employee->bank_account }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Net Salary:</label>
            <input type="number" name="net_salary" value="{{ $employee->net_salary }}" class="w-full p-2 border rounded-md" value="0">
        </div>

        <div>
            <label class="block font-medium">Nationality:</label>
            <div class="flex space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="nationality" value="WNI" class="form-radio"
                        {{ $employee->nationality == 'WNI' ? 'checked' : '' }}>
                    <span>WNI</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="nationality" value="WNA" class="form-radio"
                        {{ $employee->nationality == 'WNA' ? 'checked' : '' }}>
                    <span>WNA</span>
                    <input type="text" name="country" class="p-2 border rounded-md" placeholder="Negara"
                        value="{{ $employee->nationality == 'WNA' ? $employee->country : '' }}">
                </label>
            </div>
        </div>

        <div>
            <label class="block font-medium">Gender:</label>
            <div class="flex space-x-4">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="gender" value="Laki-Laki" class="form-radio"
                        {{ $employee->gender == 'Laki-Laki' ? 'checked' : '' }}>
                    <span>Laki-Laki</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="gender" value="Perempuan" class="form-radio"
                        {{ $employee->gender == 'Perempuan' ? 'checked' : '' }}>
                    <span>Perempuan</span>
                </label>
            </div>
        </div>

        <div>
            <label class="block font-medium">Date of Birth:</label>
            <input type="date" name="date_of_birth" value="{{ $employee->date_of_birth }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Place of Birth:</label>
            <input type="text" name="place_of_birth" value="{{ $employee->place_of_birth }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">Educational Level:</label>
            <select name="educational_level" class="w-full p-2 border rounded-md">
                @foreach(['SD/Sederajat', 'SMP/Sederajat', 'SMA/SMK/Sederajat', 'Diploma 1', 'Diploma 2', 'Diploma 3', 'Diploma 4', 'Strata 1', 'Strata 2', 'Strata 3'] as $edu)
                    <option value="{{ $edu }}" {{ $employee->educational_level == $edu ? 'selected' : '' }}>
                        {{ $edu }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Field of Study:</label>
            <input type="text" name="field_of_study" value="{{ $employee->field_of_study }}" class="w-full p-2 border rounded-md">
        </div>

        <div>
            <label class="block font-medium">School:</label>
            <input type="text" name="school" value="{{ $employee->school }}" class="w-full p-2 border rounded-md">
        </div>

        <!-- Marital Status -->
        <div>
            <label class="block font-medium text-gray-700">Status Pernikahan</label>
            <div class="flex space-x-4 mt-2">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="marital_status" value="Belum Menikah" class="marital-status"
                        {{ $employee->marital_status == 'Belum Menikah' ? 'checked' : '' }}>
                    <span>Belum Menikah</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="marital_status" value="Sudah Menikah" class="marital-status"
                        {{ $employee->marital_status == 'Sudah Menikah' ? 'checked' : '' }}>
                    <span>Sudah Menikah</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="marital_status" value="Cerai Hidup" class="marital-status"
                        {{ $employee->marital_status == 'Cerai Hidup' ? 'checked' : '' }}>
                    <span>Cerai Hidup</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="radio" name="marital_status" value="Cerai Mati" class="marital-status"
                        {{ $employee->marital_status == 'Cerai Mati' ? 'checked' : '' }}>
                    <span>Cerai Mati</span>
                </label>
            </div>
        </div>

        <!-- Nama Pasangan -->
        <div>
            <label for="spouse_complete_name" class="block font-medium text-gray-700">Nama Pasangan</label>
            <input type="text" id="spouse_complete_name" name="spouse_complete_name"
                value="{{ $employee->spouse_complete_name }}"
                class="w-full p-2 border rounded-md"
                {{ $employee->marital_status == 'Belum Menikah' ? 'disabled' : '' }}>
        </div>

        <!-- Jumlah Anak -->
        <div>
            <label for="number_of_dependent_children" class="block font-medium text-gray-700">Jumlah Anak</label>
            <div class="flex items-center space-x-2">
                <input type="number" id="number_of_dependent_children" name="number_of_dependent_children"
                    class="w-full p-2 border rounded-md"
                    value="{{ $employee->number_of_dependent_children ?? 0 }}"
                    {{ $employee->marital_status == 'Belum Menikah' ? 'disabled' : '' }}>

                <label class="flex items-center space-x-2">
                    <input type="checkbox" id="no_children" name="no_children" class="form-checkbox"
                        {{ $employee->marital_status == 'Belum Menikah' || $employee->number_of_dependent_children == 0 ? 'checked disabled' : '' }}>
                    <span>Saya belum memiliki anak</span>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Submit</button>
        </div>
    </form>
</div>

<script>
    function copyAddress() {
        document.querySelector('[name="domicile_address"]').value = document.querySelector('[name="ktp_address"]').value;
    }
    function copyCity() {
        document.querySelector('[name="domicile_city"]').value = document.querySelector('[name="ktp_city"]').value;
    }
    function setNoChildren() {
        document.querySelector('[name="number_of_dependent_children"]').value = 0;
    }
    function fillUserData() {
        var userDropdown = document.getElementById("user_id");
        var selectedOption = userDropdown.options[userDropdown.selectedIndex];

        document.getElementById("name").value = selectedOption.getAttribute("data-name") || "";
        document.getElementById("email").value = selectedOption.getAttribute("data-email") || "";
    }
    document.getElementById('position').addEventListener('change', function () {
        let position = this.value;
        let department = '';

        switch (position) {
            case 'HR':
                department = 'HR';
                break;
            case 'Kepala Akuntan':
            case 'Staff Akuntan':
                department = 'Akuntan';
                break;
            case 'Kepala Admin':
            case 'Staff Admin':
                department = 'Admin';
                break;
            case 'Kepala Produksi':
            case 'Staff Produksi':
                department = 'Produksi';
                break;
            case 'Kepala Operator dan Mekanik Alat Berat':
            case 'Staff Operator dan Mekanik Alat Berat':
                department = 'Operator dan Mekanik Alat Berat';
                break;
            case 'Kepala Mekanik Mesin Silikas':
            case 'Staff Mekanik Mesin Silikas':
                department = 'Mekanik Mesin Silikas';
                break;
            case 'Kepala Gudang':
            case 'Staff Gudang':
                department = 'Gudang';
                break;
            case 'Kepala Quality Control':
            case 'Staff Quality Control':
                department = 'QC';
                break;
            default:
                department = '';
        }

        document.getElementById('department').value = department;
    });
    document.querySelectorAll('.marital-status').forEach(radio => {
        radio.addEventListener('change', function () {
            let spouseInput = document.getElementById('spouse_complete_name');
            let childrenInput = document.getElementById('number_of_dependent_children');
            let noChildrenCheckbox = document.getElementById('no_children');

            if (this.value === 'Belum Menikah') {
                // Nonaktifkan form nama pasangan dan jumlah anak
                spouseInput.disabled = true;
                spouseInput.value = '';
                childrenInput.disabled = true;
                childrenInput.value = '0';
                noChildrenCheckbox.checked = true;
                noChildrenCheckbox.disabled = true;
            } else {
                // Aktifkan form nama pasangan dan jumlah anak
                spouseInput.disabled = false;
                childrenInput.disabled = false;
                noChildrenCheckbox.disabled = false;

                // Jika status pernikahan bukan "Sudah Menikah", nonaktifkan checkbox
                if (this.value !== 'Sudah Menikah') {
                    noChildrenCheckbox.checked = false;
                    noChildrenCheckbox.disabled = true;
                }
            }
        });
    });

    document.getElementById('no_children').addEventListener('change', function () {
        let childrenInput = document.getElementById('number_of_dependent_children');
        if (this.checked) {
            childrenInput.value = '0';
            childrenInput.disabled = true;
        } else {
            childrenInput.disabled = false;
        }
    });
</script>
@endsection
