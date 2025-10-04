<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Progress Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                        </svg>
                        Solicitud de Préstamo
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Paso 4 de 4
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                </div>
                
                <!-- Steps Indicator -->
                <div class="flex justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Información Personal</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Detalles del Préstamo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Revisión</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Documentos</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar - Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Documentos Requeridos
                        </h3>
                        
                        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 rounded-full flex items-center justify-center text-xs font-bold">1</div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Documento de Identidad</p>
                                    <p>DNI, cédula o pasaporte vigente (ambas caras)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-400 rounded-full flex items-center justify-center text-xs font-bold">2</div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Estado de Cuenta</p>
                                    <p>Estado de cuenta bancario del último mes completo</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="w-6 h-6 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center text-xs font-bold">3</div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Comprobante Laboral</p>
                                    <p>Recibo de sueldo, certificado laboral o comprobante de ingresos</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- File Requirements -->
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Requisitos de Archivos:</h4>
                            <div class="space-y-1 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    <span>Formatos: PDF, JPG, JPEG, PNG</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    <span>Tamaño máximo: 5MB por archivo</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    <span>Imágenes claras y legibles</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                    </svg>
                                    <span>Documentos vigentes y completos</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Badge -->
                        <div class="mt-6 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                                </svg>
                                <span class="text-xs font-medium">Documentos almacenados de forma segura</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Upload Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Carga de Documentos</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Sube los 3 documentos requeridos para completar tu solicitud
                            </p>
                        </div>

                        <form method="POST" action="{{ route('client.loan-application.process-step4') }}" enctype="multipart/form-data" class="p-6 space-y-8">
                            @csrf

                            @foreach($requiredDocuments as $docType => $docName)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
                                            @if($docType === 'identity')
                                                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z"/>
                                                </svg>
                                            @elseif($docType === 'bank_statement')
                                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11,8C11,9.1 11.9,10 13,10H18V12C18,13.1 17.1,14 16,14H13L11,16H16C18.2,16 20,14.2 20,12V6C20,4.89 19.1,4 18,4H13C11.89,4 11,4.89 11,6V8M5,16C5,17.1 5.9,18 7,18H10L12,20H7C4.79,20 3,18.21 3,16V10C3,8.89 3.9,8 5,8H8V10H5V16Z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @endif
                                            {{ $docName }}
                                        </h3>
                                        
                                        @if(isset($documents[$docType]))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                                </svg>
                                                Cargado
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                Requerido
                                            </span>
                                        @endif
                                    </div>

                                    @if(isset($documents[$docType]))
                                        <!-- Existing Document -->
                                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                    <div>
                                                        <p class="text-sm font-medium text-green-900 dark:text-green-100">{{ $documents[$docType]->original_name }}</p>
                                                        <p class="text-xs text-green-700 dark:text-green-300">
                                                            {{ $documents[$docType]->formatted_file_size }} • 
                                                            Subido {{ $documents[$docType]->uploaded_at->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-green-600 dark:text-green-400">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- File Upload -->
                                    <div class="relative">
                                        <input type="file" 
                                               id="{{ $docType }}" 
                                               name="{{ $docType }}" 
                                               accept=".pdf,.jpg,.jpeg,.png" 
                                               {{ !isset($documents[$docType]) ? 'required' : '' }}
                                               class="hidden"
                                               onchange="updateFileName('{{ $docType }}')">
                                        
                                        <label for="{{ $docType }}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click para subir</span> o arrastra el archivo
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, JPG, JPEG, PNG (MAX. 5MB)</p>
                                            </div>
                                        </label>
                                        
                                        <!-- File Name Display -->
                                        <div id="{{ $docType }}_filename" class="mt-2 text-sm text-gray-600 dark:text-gray-400 hidden">
                                            <span class="font-medium">Archivo seleccionado:</span> <span id="{{ $docType }}_name"></span>
                                        </div>
                                    </div>
                                    
                                    @error($docType)
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('client.loan-application.step2') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Paso Anterior
                                </a>
                                
                                <button type="submit" id="upload-btn" disabled class="inline-flex items-center px-8 py-3 bg-gray-400 text-white text-sm font-medium rounded-md shadow-sm cursor-not-allowed transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    Subir Documentos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for File Upload -->
    <script>
        function updateFileName(docType) {
            const input = document.getElementById(docType);
            const filenameDiv = document.getElementById(docType + '_filename');
            const filenameSpan = document.getElementById(docType + '_name');
            
            if (input.files.length > 0) {
                const file = input.files[0];
                filenameSpan.textContent = file.name;
                filenameDiv.classList.remove('hidden');
                
                // Validate file size
                if (file.size > 5 * 1024 * 1024) { // 5MB
                    alert('El archivo ' + file.name + ' excede el tamaño máximo de 5MB');
                    input.value = '';
                    filenameDiv.classList.add('hidden');
                    return;
                }
                
                // Validate file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de archivo no válido. Solo se permiten PDF, JPG, JPEG y PNG');
                    input.value = '';
                    filenameDiv.classList.add('hidden');
                    return;
                }
            } else {
                filenameDiv.classList.add('hidden');
            }
            
            validateForm();
        }
        
        function validateForm() {
            const requiredDocs = ['identity', 'bank_statement', 'employment_proof'];
            const uploadBtn = document.getElementById('upload-btn');
            let allValid = true;
            
            // Check existing documents
            const existingDocs = @json(array_keys($documents->toArray()));
            
            for (const docType of requiredDocs) {
                const input = document.getElementById(docType);
                const hasExisting = existingDocs.includes(docType);
                const hasNewFile = input.files.length > 0;
                
                if (!hasExisting && !hasNewFile) {
                    allValid = false;
                    break;
                }
            }
            
            if (allValid) {
                uploadBtn.disabled = false;
                uploadBtn.className = 'inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors cursor-pointer';
            } else {
                uploadBtn.disabled = true;
                uploadBtn.className = 'inline-flex items-center px-8 py-3 bg-gray-400 text-white text-sm font-medium rounded-md shadow-sm cursor-not-allowed transition-colors';
            }
        }
        
        // Initialize validation on page load
        document.addEventListener('DOMContentLoaded', validateForm);
        
        // Prevent form submission if validation fails
        document.querySelector('form').addEventListener('submit', function(e) {
            const uploadBtn = document.getElementById('upload-btn');
            if (uploadBtn.disabled) {
                e.preventDefault();
                alert('Por favor sube todos los documentos requeridos.');
                return false;
            }
        });
    </script>
</x-app-layout>
