<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.svg" type="image/svg+xml">
    <title>Database | Class Participation Application</title>
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
            overflow-x: auto;
            white-space: nowrap;
        }

        .tab-button {
            padding: 15px 25px;
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

        .table-responsive {
            margin-top: 20px;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 800px;
        }

        .table-dark th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
        }

        .table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
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

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .tab-content {
                padding: 20px;
            }

            .table-responsive {
                margin-top: 15px;
            }

            .table td, .table th {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Database Management</h1>
            <p>Class Participation Application</p>
            <p><button class="btn" onclick="window.location.href='index.php'" style="margin-top: 20px; max-width: 300px;">🏠 Kembali ke Beranda</button></p>
        </div>

        <div class="tab-container">
            <div class="tab-buttons">
                <button class="tab-button active" onclick="showTab('students')">👨‍🎓 Students</button>
                <button class="tab-button" onclick="showTab('classes')">📚 Classes</button>
                <button class="tab-button" onclick="showTab('enrollments')">📝 Enrollments</button>
                <button class="tab-button" onclick="showTab('assessors')">👨‍🏫 Assessors</button>
                <button class="tab-button" onclick="showTab('participations')">📈 Participations</button>
            </div>

            <div class="tab-content">
                <!-- Students Tab -->
                <div id="students-tab" class="tab-pane">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once 'config.php';
                                
                                try {
                                    $pdo = getConnection();
                                    $stmt = $pdo->query("SELECT student_id, NAME, email, created_at FROM students");
                                    $students = $stmt->fetchAll();
                                    
                                    if (count($students) > 0) {
                                        foreach($students as $row) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["student_id"] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row["NAME"] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row["email"] ?? '') . "</td>";
                                            echo "<td>" . htmlspecialchars($row["created_at"] ?? '') . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No data available</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='4' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Classes Tab -->
                <div id="classes-tab" class="tab-pane" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Class Code</th>
                                    <th>Class Name</th>
                                    <th>Description</th>
                                    <th>Instructor</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $pdo->query("SELECT class_code, class_name, description, instructor, created_at FROM classes");
                                    $classes = $stmt->fetchAll();
                                    
                                    if (count($classes) > 0) {
                                        foreach($classes as $row) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["class_code"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["class_name"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["instructor"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='5' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enrollments Tab -->
                <div id="enrollments-tab" class="tab-pane" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Class Code</th>
                                    <th>Enrollment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $pdo->query("SELECT * FROM enrollments");
                                    $enrollments = $stmt->fetchAll();
                                    
                                    if (count($enrollments) > 0) {
                                        foreach($enrollments as $row) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["student_id"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["class_code"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["enrolled_at"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>No data available</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='3' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Assessors Tab -->
                <div id="assessors-tab" class="tab-pane" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Assessor ID</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $pdo->query("SELECT * FROM assessors");
                                    $assessors = $stmt->fetchAll();
                                    
                                    if (count($assessors) > 0) {
                                        foreach($assessors as $row) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["assessor_id"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["created_at"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No data available</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='5' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Participations Tab -->
                <div id="participations-tab" class="tab-pane" style="display: none;">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Class Code</th>
                                    <th>Assessor ID</th>
                                    <th>Participation Score</th>
                                    <th>Speaking Quality</th>
                                    <th>Engagement Level</th>
                                    <th>Feedback</th>
                                    <th>Assessment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $pdo->query("SELECT * FROM participations");
                                    $participations = $stmt->fetchAll();
                                    
                                    if (count($participations) > 0) {
                                        foreach($participations as $row) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row["student_id"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["class_code"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["assessor_id"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["participation_score"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["speaking_quality"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["engagement_level"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["feedback"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["assessment_date"]) . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='8' class='text-center text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                                }
                                
                                closeConnection();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-pane').forEach(tab => {
                tab.style.display = 'none';
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').style.display = 'block';
            
            // Add active class to selected button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
