import Swal from 'sweetalert2';

// Función para confirmar la generación de contrato
window.confirmContractGeneration = function(url) {
    Swal.fire({
        title: '¿Generar Contrato?',
        html: `
            <div class="text-left">
                <p class="mb-4">¿Estás seguro de que deseas generar el contrato para este préstamo?</p>
                <div class="bg-blue-900/30 border border-blue-700 rounded-lg p-4">
                    <h4 class="font-semibold text-blue-300 mb-2">📄 Información del Contrato</h4>
                    <ul class="text-sm text-blue-200 space-y-1">
                        <li>• Se generará un PDF profesional con todos los datos</li>
                        <li>• Incluirá tabla de amortización completa</li>
                        <li>• Contendrá términos y condiciones legales</li>
                        <li>• Estará disponible para descarga inmediata</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981', // green-500
        cancelButtonColor: '#6b7280', // gray-500
        confirmButtonText: `
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Sí, Generar Contrato
        `,
        cancelButtonText: `
            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancelar
        `,
        reverseButtons: true,
        customClass: {
            popup: 'rounded-lg shadow-xl bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-600',
            title: 'text-white dark:text-white',
            htmlContainer: 'text-gray-300 dark:text-gray-300',
            confirmButton: 'px-6 py-2 rounded-md font-medium transition-colors bg-green-600 hover:bg-green-700 text-white',
            cancelButton: 'px-6 py-2 rounded-md font-medium transition-colors bg-gray-600 hover:bg-gray-700 text-white'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Generando Contrato...',
                html: `
                    <div class="text-center">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-green-500 mb-4"></div>
                        <p class="text-gray-300">Por favor espera mientras se genera el contrato PDF</p>
                    </div>
                `,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-lg shadow-xl bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-600',
                    title: 'text-white dark:text-white',
                    htmlContainer: 'text-gray-300 dark:text-gray-300'
                }
            });

            // Crear un formulario POST para generar el contrato
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            
            // Agregar token CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Agregar el formulario al DOM y enviarlo
            document.body.appendChild(form);
            form.submit();
        }
    });
};

// Función para mostrar éxito después de generar contrato
window.showContractSuccess = function() {
    Swal.fire({
        title: '¡Contrato Generado!',
        html: `
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20 mb-4">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-gray-300 mb-4">El contrato se ha generado exitosamente y está listo para ver y descargar.</p>
                <div class="bg-green-900/30 border border-green-700 rounded-lg p-3 mb-4">
                    <p class="text-sm text-green-200">Ahora puedes ver el contrato, descargarlo o regresar a los detalles de la solicitud.</p>
                </div>
                <div class="flex space-x-3 justify-center">
                    <button onclick="window.location.reload()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-800 dark:text-green-200 dark:hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Contrato
                    </button>
                </div>
            </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-lg shadow-xl bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-600',
            title: 'text-white dark:text-white',
            htmlContainer: 'text-gray-300 dark:text-gray-300'
        }
    });
};

// Función para mostrar error
window.showContractError = function(message) {
    Swal.fire({
        title: 'Error al Generar Contrato',
        html: `
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 mb-4">
                    <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <p class="text-gray-300 mb-4">${message || 'Ocurrió un error inesperado al generar el contrato.'}</p>
                <div class="bg-red-900/30 border border-red-700 rounded-lg p-3">
                    <p class="text-sm text-red-200">Por favor intenta nuevamente o contacta al administrador si el problema persiste.</p>
                </div>
            </div>
        `,
        icon: 'error',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#ef4444',
        customClass: {
            popup: 'rounded-lg shadow-xl bg-gray-800 dark:bg-gray-900 border border-gray-700 dark:border-gray-600',
            title: 'text-white dark:text-white',
            htmlContainer: 'text-gray-300 dark:text-gray-300',
            confirmButton: 'px-6 py-2 rounded-md font-medium transition-colors bg-red-600 hover:bg-red-700 text-white'
        }
    });
};
        