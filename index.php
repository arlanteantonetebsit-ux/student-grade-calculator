<?php
// Initialize variables
$studentName = $yearLevel = $term = "";
$math = $english = $science = $programming = "";
$average = 0;
$status = "";
$submitted = false;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $studentName = trim($_POST["student_name"] ?? "");
    $yearLevel = $_POST["year_level"] ?? "";
    $term = $_POST["term"] ?? "";
    $math = (float)($_POST["math"] ?? 0);
    $english = (float)($_POST["english"] ?? 0);
    $science = (float)($_POST["science"] ?? 0);
    $programming = (float)($_POST["programming"] ?? 0);

    // Calculate average
    $average = ($math + $english + $science + $programming) / 4;

    // Determine status
    $status = $average >= 75 ? "PASSED" : "FAILED";
    $submitted = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grade Calculator</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #333333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding: 30px;
        }

        .container {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            padding: 30px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
            color: #111;
        }

        h2 {
            font-size: 16px;
            margin: 18px 0 10px;
            color: #222;
            padding-bottom: 4px;
            border-bottom: 1px solid #eee;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 5px;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #2b2b2b;
            color: #fff;
            border: none;
            margin-top: 8px;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        button:hover {
            background-color: #111;
        }

        .result-box {
            background-color: #f7f7f7;
            margin-top: 20px;
            padding: 15px;
            border-radius: 6px;
        }

        .result-box p {
            font-size: 14px;
            margin: 6px 0;
        }

        .status-fail {
            color: #c00;
            font-weight: bold;
        }

        .status-pass {
            color: #080;
            font-weight: bold;
        }

        hr {
            margin: 8px 0;
            border: none;
            border-bottom: 1px solid #ccc;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Student Grade Calculator</h1>

    <form method="post" id="gradeForm">
        <h2>Student Information</h2>

        <div class="form-group">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required>
        </div>

        <div class="form-group">
            <label for="year_level">Year Level:</label>
            <select id="year_level" name="year_level" required>
                <option value="">Select Year</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>
        </div>

        <div class="form-group">
            <label for="term">Term:</label>
            <select id="term" name="term" required>
                <option value="">Select Term</option>
                <option value="Prelim">Prelim</option>
                <option value="Midterm">Midterm</option>
                <option value="Finals">Finals</option>
            </select>
        </div>

        <h2>Grades</h2>

        <div class="form-group">
            <label for="math">Mathematics:</label>
            <input type="number" step="0.01" min="0" max="100" id="math" name="math" required>
        </div>

        <div class="form-group">
            <label for="english">English:</label>
            <input type="number" step="0.01" min="0" max="100" id="english" name="english" required>
        </div>

        <div class="form-group">
            <label for="science">Science:</label>
            <input type="number" step="0.01" min="0" max="100" id="science" name="science" required>
        </div>

        <div class="form-group">
            <label for="programming">Programming:</label>
            <input type="number" step="0.01" min="0" max="100" id="programming" name="programming" required>
        </div>

        <button type="submit">Calculate Grade</button>
    </form>

    <?php if ($submitted): ?>
    <div class="result-box">
        <h2>Grade Result</h2>
        <p><strong>Student Name:</strong> <?= htmlspecialchars($studentName) ?></p>
        <p><strong>Year Level:</strong> <?= htmlspecialchars($yearLevel) ?></p>
        <p><strong>Term:</strong> <?= htmlspecialchars($term) ?></p>
        <hr>
        <p><strong>Average:</strong> <?= number_format($average, 2) ?></p>
        <p><strong>Status:</strong>
            <span class="<?= $status === 'FAILED' ? 'status-fail' : 'status-pass' ?>">
                <?= $status ?>
            </span>
        </p>
    </div>
    <?php endif; ?>
</div>

<script>
    // Client-side validation
    const form = document.getElementById('gradeForm');
    form.addEventListener('submit', function(e) {
        const inputs = form.querySelectorAll('input[type="number"]');
        for (const inp of inputs) {
            const val = parseFloat(inp.value);
            if (isNaN(val) || val < 0 || val > 100) {
                alert(inp.previousElementSibling.textContent.replace(':', '') + " must be between 0 and 100");
                e.preventDefault();
                return;
            }
        }
    });
</script>

</body>
</html>
