<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.svg" type="image/svg+xml">
    <title> Class Participation Application </title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .tab-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }

        .tab-buttons {
            display: flex;
            background: #f8f9fa;
        }

        .tab-button {
            flex: 1;
            padding: 15px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #666;
        }

        .tab-button.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .tab-content {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .results {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 5px solid #667eea;
        }

        .score-display {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .score-item {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .score-value {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .score-label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }

        .feedback-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #28a745;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .rating-input {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .rating-input input[type="radio"] {
            width: auto;
            margin: 0;
        }

        .hidden {
            display: none;
        }

        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        .assessment-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .assessment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .assessment-date {
            color: #666;
            font-size: 0.9rem;
        }

        .assessor-info {
            color: #667eea;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .tab-buttons {
                flex-direction: column;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .tab-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Class Participation Application</h1>
            <p>By Aynayya Almateta Fransilia</p>
        </div>

        <div class="tab-container">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('student')">👨‍🎓 Student Portal</button>
                <button class="tab-button" onclick="showTab('assessor')">👨‍🏫 Assessor Portal</button>
                <button class="tab-button" onclick="showTab('admin')">⚙️ Admin</button>
                <button class="tab-button" onclick="window.location.href='database.php'">🗃️ Database</button>
            </div>

            <!-- Student Tab -->
            <div id="student-tab" class="tab-content">
                <h2>🔍 View Scores and Feedback</h2>
                <form id="studentForm">
                    <div class="form-group">
                        <label for="student_id">Student ID:</label>
                        <input type="text" id="student_id" name="student_id" placeholder="Example: 23A1" required>
                    </div>
                    <div class="form-group">
                        <label for="class_code_student">Class Code:</label>
                        <select id="class_code_student" name="class_code" required>
                            <option value="">Loading classes...</option>
                        </select>
                    </div>
                    <button type="submit" class="btn" id="studentSubmitBtn">📊 View Results</button>
                </form>
                <div id="studentResults"></div>
            </div>

            <!-- Assessor Tab -->
            <div id="assessor-tab" class="tab-content hidden">
                <h2>📝 Give Assessment</h2>
                <form id="assessorForm">
                    <div class="form-group">
                        <label for="assessor_id">Assessor ID:</label>
                        <input type="text" id="assessor_id" name="assessor_id" placeholder="Example: ENG0102" required>
                    </div>
                    <div class="form-group">
                        <label for="student_id_assess">Student ID to Assess:</label>
                        <input type="text" id="student_id_assess" name="student_id" placeholder="Example: 23A1" required>
                    </div>
                    <div class="form-group">
                        <label for="class_code_assess">Class Code:</label>
                        <select id="class_code_assess" name="class_code" required>
                            <option value="">Loading classes...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="participation_score">Participation Score (0-100):</label>
                        <input type="number" id="participation_score" name="participation_score" min="0" max="100" required>
                    </div>
                    <div class="form-group">
                        <label>Speaking Quality (1-5):</label>
                        <div class="rating-input">
                            <input type="radio" id="speak1" name="speaking_quality" value="1" required>
                            <label for="speak1">1</label>
                            <input type="radio" id="speak2" name="speaking_quality" value="2">
                            <label for="speak2">2</label>
                            <input type="radio" id="speak3" name="speaking_quality" value="3">
                            <label for="speak3">3</label>
                            <input type="radio" id="speak4" name="speaking_quality" value="4">
                            <label for="speak4">4</label>
                            <input type="radio" id="speak5" name="speaking_quality" value="5">
                            <label for="speak5">5</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Engagement Level (1-5):</label>
                        <div class="rating-input">
                            <input type="radio" id="engage1" name="engagement_level" value="1" required>
                            <label for="engage1">1</label>
                            <input type="radio" id="engage2" name="engagement_level" value="2">
                            <label for="engage2">2</label>
                            <input type="radio" id="engage3" name="engagement_level" value="3">
                            <label for="engage3">3</label>
                            <input type="radio" id="engage4" name="engagement_level" value="4">
                            <label for="engage4">4</label>
                            <input type="radio" id="engage5" name="engagement_level" value="5">
                            <label for="engage5">5</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="feedback">Feedback:</label>
                        <textarea id="feedback" name="feedback" rows="4" placeholder="Provide constructive feedback..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="assessment_date">Assessment Date:</label>
                        <input type="date" id="assessment_date" name="assessment_date" required>
                    </div>
                    <button type="submit" class="btn" id="assessorSubmitBtn">💾 Save Assessment</button>
                </form>
                <div id="assessorResults"></div>
            </div>

            <!-- Admin Tab -->
            <div id="admin-tab" class="tab-content hidden">
                <h2>⚙️ Administration Panel</h2>
                <div class="admin-stats" id="adminStats">
                    <div class="loading">📊 Loading system statistics...</div>
                </div>
                
                <div style="margin-top: 30px;">
                    <h3>📋 Recent Assessments</h3>
                    <div id="recentAssessments">
                        <div class="loading">📝 Loading recent assessments...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // API Base URL
        const API_URL = 'api.php';

        // Set today's date as default
        document.getElementById('assessment_date').valueAsDate = new Date();

        // Tab functionality
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.remove('hidden');
            
            // Add active class to selected button
            event.target.classList.add('active');
            
            // Load data when tab is shown
            if (tabName === 'student' || tabName === 'assessor') {
                loadClasses();
            } else if (tabName === 'admin') {
                loadAdminData();
            }
        }

        // API Helper function
        async function apiCall(action, data = null, method = 'GET') {
            try {
                const config = {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    }
                };
                
                if (data && method === 'POST') {
                    config.body = JSON.stringify(data);
                }
                
                const response = await fetch(`${API_URL}?action=${action}`, config);
                const result = await response.json();
                
                if (!response.ok) {
                    throw new Error(result.error || 'API Error');
                }
                
                return result;
            } catch (error) {
                console.error('API Call Error:', error);
                throw error;
            }
        }

        // Load classes for dropdowns
        async function loadClasses() {
            try {
                const result = await apiCall('get_classes');
                
                if (result.success) {
                    const studentSelect = document.getElementById('class_code_student');
                    const assessorSelect = document.getElementById('class_code_assess');
                    
                    // Clear existing options
                    studentSelect.innerHTML = '<option value="">Select Class</option>';
                    assessorSelect.innerHTML = '<option value="">Select Class</option>';
                    
                    // Add class options
                    result.data.forEach(cls => {
                        const option1 = new Option(`${cls.class_code} - ${cls.class_name} (${cls.instructor})`, cls.class_code);
                        const option2 = new Option(`${cls.class_code} - ${cls.class_name} (${cls.instructor})`, cls.class_code);
                        studentSelect.add(option1);
                        assessorSelect.add(option2);
                    });
                }
            } catch (error) {
                showAlert('error', 'Failed to load classes: ' + error.message);
            }
        }

        // Student form submission
        document.getElementById('studentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('studentSubmitBtn');
            const originalText = submitBtn.textContent;
            
            try {
                submitBtn.disabled = true;
                submitBtn.textContent = '⏳ Memuat...';
                
                const formData = new FormData(this);
                const data = {
                    student_id: formData.get('student_id'),
                    class_code: formData.get('class_code')
                };
                
                const result = await apiCall('get_student_results', data, 'POST');
                showStudentResults(result);
                
            } catch (error) {
                showAlert('error', 'Gagal memuat hasil: ' + error.message, 'studentResults');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Assessor form submission
        document.getElementById('assessorForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('assessorSubmitBtn');
            const originalText = submitBtn.textContent;
            
            try {
                submitBtn.disabled = true;
                submitBtn.textContent = '⏳ Menyimpan...';
                
                const formData = new FormData(this);
                const data = {
                    assessor_id: formData.get('assessor_id'),
                    student_id: formData.get('student_id'),
                    class_code: formData.get('class_code'),
                    participation_score: parseInt(formData.get('participation_score')),
                    speaking_quality: parseInt(formData.get('speaking_quality')),
                    engagement_level: parseInt(formData.get('engagement_level')),
                    feedback: formData.get('feedback'),
                    assessment_date: formData.get('assessment_date')
                };
                
                const result = await apiCall('save_assessment', data, 'POST');
                showAlert('success', 'Penilaian berhasil disimpan!', 'assessorResults');
                this.reset();
                document.getElementById('assessment_date').valueAsDate = new Date();
                
            } catch (error) {
                showAlert('error', 'Gagal menyimpan penilaian: ' + error.message, 'assessorResults');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });

        // Load admin data
        async function loadAdminData() {
            try {
                const statsResult = await apiCall('get_admin_stats');
                const recentResult = await apiCall('get_recent_assessments');
                
                if (statsResult.success) {
                    showAdminStats(statsResult.data);
                }
                
                if (recentResult.success) {
                    showRecentAssessments(recentResult.data);
                }
            } catch (error) {
                showAlert('error', 'Gagal memuat data admin: ' + error.message, 'adminStats');
            }
        }

        // Show student results
        function showStudentResults(result) {
            const container = document.getElementById('studentResults');
            
            if (!result.success || !result.data) {
                showAlert('error', 'No data found for this Student ID and selected Class.', 'studentResults');
                return;
            }
            
            const data = result.data;
            
            let html = `
                <div class="results">
                    <h3>Assessment Results for ${data.student_name}</h3>
                    <div class="score-display">
                        <div class="score-item">
                            <div class="score-value">${data.averages.participation}</div>
                            <div class="score-label">Average Participation</div>
                        </div>
                        <div class="score-item">
                            <div class="score-value">${data.averages.speaking}</div>
                            <div class="score-label">Average Speaking Quality</div>
                        </div>
                        <div class="score-item">
                            <div class="score-value">${data.averages.engagement}</div>
                            <div class="score-label">Average Engagement</div>
                        </div>
                    </div>
                    <h4 style="margin-top: 20px;">Assessment History:</h4>
            `;

            if (data.assessments && data.assessments.length > 0) {
                data.assessments.forEach(assessment => {
                    html += `
                        <div class="assessment-card">
                            <div class="assessment-header">
                                <div>
                                    <strong>Date: ${assessment.assessment_date}</strong>
                                    <span class="assessor-info"> - Assessed by ${assessment.assessor_name}</span>
                                </div>
                            </div>
                            <div class="score-display">
                                <div class="score-item">
                                    <div class="score-value">${assessment.participation_score}</div>
                                    <div class="score-label">Participation Score</div>
                                </div>
                                <div class="score-item">
                                    <div class="score-value">${assessment.speaking_quality}</div>
                                    <div class="score-label">Speaking Quality</div>
                                </div>
                                <div class="score-item">
                                    <div class="score-value">${assessment.engagement_level}</div>
                                    <div class="score-label">Engagement Level</div>
                                </div>
                            </div>
                            <div class="feedback-box">
                                <p>${assessment.feedback || 'No feedback provided'}</p>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `<div class="alert alert-info">No assessments available for student ${data.student_name} in this class.</div>`;
            }
            
            html += '</div>';
            container.innerHTML = html;
        }

        // Show admin statistics
        function showAdminStats(data) {
            const container = document.getElementById('adminStats');
            
            let html = `
                <div class="score-display">
                    <div class="score-item">
                        <div class="score-value">${data.total_students}</div>
                        <div class="score-label">Total Students</div>
                    </div>
                    <div class="score-item">
                        <div class="score-value">${data.total_classes}</div>
                        <div class="score-label">Total Classes</div>
                    </div>
                    <div class="score-item">
                        <div class="score-value">${data.total_assessments}</div>
                        <div class="score-label">Total Assessments</div>
                    </div>
                    <div class="score-item">
                        <div class="score-value">${data.avg_participation}</div>
                        <div class="score-label">Average Participation</div>
                    </div>
                </div>
            `;
            
            container.innerHTML = html;
        }

        // Show recent assessments
        function showRecentAssessments(data) {
            const container = document.getElementById('recentAssessments');
            
            if (!data || data.length === 0) {
                container.innerHTML = '<div class="alert alert-info">No recent assessments available</div>';
                return;
            }
            
            let html = '';
            data.forEach(assessment => {
                html += `
                    <div class="assessment-card">
                        <div class="assessment-header">
                            <div>
                                <strong>${assessment.student_name}</strong>
                                <span class="assessor-info"> - Assessed by ${assessment.assessor_name}</span>
                            </div>
                            <span class="assessment-date">${assessment.assessment_date}</span>
                        </div>
                        <div class="score-display">
                            <div class="score-item">
                                <div class="score-value">${assessment.participation_score}</div>
                                <div class="score-label">Participation Score</div>
                            </div>
                            <div class="score-item">
                                <div class="score-value">${assessment.speaking_quality}</div>
                                <div class="score-label">Speaking Quality</div>
                            </div>
                            <div class="score-item">
                                <div class="score-value">${assessment.engagement_level}</div>
                                <div class="score-label">Engagement Level</div>
                            </div>
                        </div>
                        <div class="feedback-box">
                            <p>${assessment.feedback}</p>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // Show alert message
        function showAlert(type, message, containerId = null) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;
            
            if (containerId) {
                const container = document.getElementById(containerId);
                container.innerHTML = '';
                container.appendChild(alertDiv);
            } else {
                document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.tab-container'));
            }
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            loadClasses();
        });
    </script>
</body>
</html>