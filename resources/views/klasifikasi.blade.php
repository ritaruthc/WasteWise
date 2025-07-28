@extends('layouts.app')

@section('title', 'Klasifikasi Sampah - Edukasi Pemilahan Sampah')

@section('styles')
    <style>
        body {
            background: linear-gradient(135deg, #114B5F, #1A946F, #88D398, #F3E8D2);
            min-height: 100vh;
            margin: 0;
        }

        /* body {
        background-image: linear-gradient(to bottom right, #11998e, #38ef7d);
    } */
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            min-height: 200px;
            position: relative;
        }

        .upload-area:hover {
            background-color: #f8f9fa;
        }

        .upload-icon {
            font-size: 48px;
            color: #6c757d;
        }

        #preview-image {
            max-width: 100%;
            max-height: 300px;
            margin-top: 20px;
            object-fit: contain;
            display: none;
        }

        .cancel-icon-container {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            display: none;
        }

        .cancel-icon-container:hover {
            background-color: #ff6b6b;
        }

        .cancel-icon-container:hover .cancel-icon {
            color: #fff;
        }

        .cancel-icon {
            font-size: 16px;
            color: #ff6b6b;
        }

        .upload-text {
            margin-top: 10px;
        }

        .result-card {
            display: none;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            display: none;
        }

        .loading-spinner-container {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .loading-spinner {
            width: 100%;
            height: 100%;
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            font-weight: bold;
            color: #fff;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-text {
            display: none;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #3498db;
        }

        .info-card {
            display: none;
            margin-top: 20px;
        }

        .info-icon {
            font-size: 24px;
            color: #6c757d;
            margin-right: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .disabled-button {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .layout-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .upload-section,
        .result-section {
            width: 48%;
            display: flex;
            flex-direction: column;
        }

        .upload-section .card,
        .result-section .card {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .upload-section .card-body,
        .result-section .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .info-section {
            width: 100%;
            margin-top: 20px;
        }

        #classification-chart {
            width: 100%;
            height: auto;
            max-height: 300px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <div class="text-center">
            <h1 class="mb-4" style="color: white"><strong>Klasifikasi Sampah</strong></h1>
            <p class="lead mb-2" style="color: white">Unggah foto sampah dan sistem kami akan mengklasifikasikannya untuk
                Anda.</p>
        </div>
        <section id="view-gif" class="py-5">
            <div class="container text-center">
                <div class="gif-container">
                    <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/home/klas.gif" alt="Dampak Klasifikasi Sampah"
                        class="img-fluid rounded shadow" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </section>


        <div class="layout-container">
            <div class="upload-section">
                <div class="card" style="height: 463px";>
                    <div class="card-body">
                        <h5 class="card-title mb-3">Unggah Foto Sampah</h5>
                        <div class="content-wrapper">
                            <form id="upload-form" enctype="multipart/form-data">
                                @csrf
                                <div class="upload-area mb-3" id="drop-area">
                                    <input type="file" id="file-input" name="image" accept="image/*"
                                        style="display: none;">
                                    <div class="cancel-icon-container" id="cancel-icon-container">
                                        <div class="cancel-icon">✖</div>
                                    </div>
                                    <img id="preview-image" class="mt-3">
                                    <div id="upload-placeholder">
                                        <div class="upload-icon mb-2">📸</div>
                                        <p class="upload-text">Klik atau seret foto ke sini</p>
                                    </div>
                                    <div class="loading-overlay" id="loading-overlay">
                                        <div class="loading-spinner-container">
                                            <div class="loading-spinner"></div>
                                            <div class="loading-percentage" id="loading-percentage">0%</div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="classify-button"
                                    class="btn btn-success w-100 disabled-button custom-green-button"
                                    disabled>Klasifikasikan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="result-section">
                <div class="card result-card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Hasil Klasifikasi</h5>
                        <div class="content-wrapper">
                            <div id="result-content">
                                <!-- Hasil klasifikasi akan ditampilkan di sini -->
                            </div>
                            <canvas id="classification-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informasi Tambahan</h5>
                    <div id="info-content">
                        <!-- Informasi tambahan akan ditampilkan di sini -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('file-input');
            const previewImage = document.getElementById('preview-image');
            const cancelIconContainer = document.getElementById('cancel-icon-container');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const uploadForm = document.getElementById('upload-form');
            const classifyButton = document.getElementById('classify-button');
            const resultCard = document.querySelector('.result-card');
            const resultContent = document.getElementById('result-content');
            const ctx = document.getElementById('classification-chart').getContext('2d');
            const infoCard = document.querySelector('.info-card');
            const infoContent = document.getElementById('info-content');
            const loadingOverlay = document.getElementById('loading-overlay');
            const loadingPercentage = document.getElementById('loading-percentage');
            const loadingSpinner = document.querySelector('.loading-spinner');
            let classificationChart;

            // Disable classify button initially
            classifyButton.classList.add('disabled-button');
            classifyButton.disabled = true;

            // Trigger file input when clicking on drop area
            dropArea.addEventListener('click', () => fileInput.click());

            // Handle drag and drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function adjustHeights() {
                const uploadSection = document.querySelector('.upload-section .card');
                const resultSection = document.querySelector('.result-section .card');
                const uploadContent = uploadSection.querySelector('.content-wrapper');
                const resultContent = resultSection.querySelector('.content-wrapper');

                // Reset heights
                uploadSection.style.height = 'auto';
                resultSection.style.height = 'auto';
                uploadContent.style.height = 'auto';
                resultContent.style.height = 'auto';

                // Force a reflow
                void uploadSection.offsetHeight;
                void resultSection.offsetHeight;

                // Get the maximum height
                const maxHeight = Math.max(uploadSection.offsetHeight, resultSection.offsetHeight);

                // Set both outer cards to the maximum height
                uploadSection.style.height = `${maxHeight}px`;
                resultSection.style.height = `${maxHeight}px`;

                // Set inner content wrappers to fill the cards
                uploadContent.style.height = '100%';
                resultContent.style.height = '100%';
            }

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                handleFiles(files);
            }

            // Handle selected files
            fileInput.addEventListener('change', function() {
                handleFiles(this.files);
            });

            function handleFiles(files) {
                if (files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImage.src = e.target.result;
                            previewImage.style.display = 'block';
                            uploadPlaceholder.style.display = 'none';
                            classifyButton.classList.remove('disabled-button');
                            classifyButton.disabled = false;
                            cancelIconContainer.style.display = 'flex';
                            requestAnimationFrame(() => {
                                requestAnimationFrame(adjustHeights);
                            });
                        }
                        reader.readAsDataURL(file);
                    } else {
                        alert('Mohon unggah file gambar.');
                        fileInput.value = '';
                    }
                }
            }

            cancelIconContainer.addEventListener('click', function(e) {
                e.stopPropagation();
                fileInput.value = '';
                previewImage.style.display = 'none';
                previewImage.src = '';
                uploadPlaceholder.style.display = 'block';
                classifyButton.classList.add('disabled-button');
                classifyButton.disabled = true;
                cancelIconContainer.style.display = 'none';
                requestAnimationFrame(adjustHeights);
            });


            async function loadModel() {
                const model = await tf.loadGraphModel('/model/json/model.json');
                return model;
            }

            function imageClasses() {
                const classes = {
                    0: 'Elektronik',
                    1: 'Biologis',
                    2: 'Kaca Coklat',
                    3: 'Kardus',
                    4: 'Tekstil',
                    5: 'Kaca Hijau',
                    6: 'Logam',
                    7: 'Kertas',
                    8: 'Plastik',
                    9: 'Sepatu',
                    10: 'Residu',
                    11: 'Kaca Putih'
                };
                return classes;
            }

            async function classifyModel(image) {
                const model = await loadModel();
                const IMAGE_CLASSES = imageClasses();

                const tensorImg = tf.browser.fromPixels(image).resizeNearestNeighbor([224, 224]).toFloat()
                    .expandDims();
                const prediction = await model.predict(tensorImg).data();
                const results = Array.from(prediction).map((probability, index) => {
                    return {
                        probability: probability,
                        className: IMAGE_CLASSES[index]
                    };
                }).sort((a, b) => b.probability - a.probability).slice(0, 3);

                return results;
            }

            function updateLoadingPercentage(percentage) {
                loadingPercentage.textContent = `${percentage}%`;
                loadingSpinner.style.transform = `rotate(${percentage * 3.6}deg)`;
            }

            function simulateLoading(callback) {
                let progress = 0;
                const interval = setInterval(() => {
                    progress += Math.random() * 10;
                    if (progress > 100) progress = 100;
                    updateLoadingPercentage(Math.round(progress));
                    if (progress === 100) {
                        clearInterval(interval);
                        setTimeout(() => {
                            loadingOverlay.style.display = 'none';
                            callback(); // Panggil callback setelah loading selesai
                        }, 500);
                    }
                }, 200);
            }

            uploadForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                loadingOverlay.style.display = 'flex';
                updateLoadingPercentage(0);

                // Sembunyikan hasil sebelumnya
                resultCard.style.display = 'none';
                infoCard.style.display = 'none';

                // Simulate loading process
                simulateLoading(async () => {
                    const imageElement = previewImage;
                    const results = await classifyModel(imageElement);

                    let resultHTML = '<ul>';
                    const labels = [];
                    const data = [];
                    let highestResult = results[0];

                    results.forEach(result => {
                        resultHTML +=
                            `<li><strong>${result.className}</strong>: ${(result.probability * 100).toFixed(2)}%</li>`;
                        labels.push(result.className);
                        data.push(result.probability * 100);
                    });

                    resultHTML += '</ul>';
                    resultContent.innerHTML = resultHTML;

                    // Tampilkan hasil klasifikasi
                    resultCard.style.display = 'block';

                    // Buat atau perbarui grafik
                    if (classificationChart) {
                        classificationChart.destroy();
                    }
                    classificationChart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Probabilitas (%)',
                                data: data,
                                backgroundColor: ['#FF6384', '#36A2EB',
                                    '#FFCE56'
                                ],
                            }]
                        }
                    });

                    // Ambil dan tampilkan informasi tambahan
                    try {
                        const response = await fetch(
                            `/waste-category/${encodeURIComponent(highestResult.className)}`
                            );

                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        const contentType = response.headers.get("content-type");
                        if (!contentType || !contentType.includes("application/json")) {
                            throw new TypeError("Oops, we haven't got JSON!");
                        }

                        const data = await response.json();
                        console.log('Received data:', data);

                        // Periksa apakah data memiliki properti yang diharapkan
                        if (!data.category || !data.info || !data.handling_info) {
                            throw new Error("Data tidak lengkap");
                        }

                        let infoHTML = `
                    <div class="info-item">
                        <i class="info-icon fas fa-tag"></i>
                        <p><strong>Kategori:</strong> ${data.category}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-info-circle"></i>
                        <p><strong>Penjelasan:</strong> ${data.info}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-hands-helping"></i>
                        <p><strong>Cara Penanganan:</strong> ${data.handling_info}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-leaf"></i>
                        <p><strong>Dampak Lingkungan:</strong> ${data.environmental_impact}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-recycle"></i>
                        <p><strong>Potensi Daur Ulang:</strong> ${data.recycling_potential}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-hourglass-half"></i>
                        <p><strong>Waktu Terurai:</strong> ${data.decomposition_time}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-lightbulb"></i>
                        <p><strong>Tips Mengurangi:</strong> ${data.reduction_tips}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-box"></i>
                        <p><strong>Contoh Lain:</strong> ${data.other_examples}</p>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-gavel"></i>
                        <p><strong>Regulasi:</strong> ${data.regulations}</p>
                    </div>
                `;
                        infoContent.innerHTML = infoHTML;
                        infoCard.style.display = 'block';
                    } catch (error) {
                        console.error('Error fetching category info:', error);
                        let errorMessage =
                            'Maaf, terjadi kesalahan saat mengambil informasi tambahan.';
                        if (error instanceof TypeError) {
                            errorMessage += ' Format data tidak sesuai.';
                        } else if (error instanceof Error && error.message ===
                            "Data tidak lengkap") {
                            errorMessage += ' Data yang diterima tidak lengkap.';
                        } else if (error.message.startsWith('HTTP error!')) {
                            errorMessage +=
                                ` Kode status: ${error.message.split(':')[1].trim()}.`;
                        }
                        infoContent.innerHTML =
                            `<p>${errorMessage}</p><p>Silakan coba lagi nanti atau hubungi administrator.</p>`;
                        infoCard.style.display = 'block';
                    }

                    requestAnimationFrame(() => {
                        requestAnimationFrame(adjustHeights);
                    });
                });
            });
            window.addEventListener('resize', () => {
                requestAnimationFrame(adjustHeights);
            });

            // Initial height adjustment
            requestAnimationFrame(adjustHeights);
        });
    </script>
@endsection
