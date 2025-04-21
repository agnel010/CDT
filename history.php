<?php
// Check if history_process.php exists and include it
if (file_exists('history_process.php')) {
    include 'history_process.php';
} else {
    $error = "Error: Database connection file not found.";
    $countdowns = [];
    $user_id = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="View your countdown history with detailed timer information.">
    <meta name="author" content="Countdown App">
    <title>Countdown History - Timer Management</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
        :root {
            --primary-color: #4B0082;
            --secondary-color: #9370DB;
            --gradient-start: #4B0082;
            --gradient-end: #9370DB;
            --card-bg-start: #E6E6FA;
            --card-bg-end: #F0EAF7;
            --text-color: #ffffff;
            --table-header: #9370DB;
            --table-header-end: #8A2BE2;
            --shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            --shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.25);
            --border-color: #D8BFD8;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #1f2937;
            line-height: 1.6;
        }

        .card {
            background: linear-gradient(to bottom, var(--card-bg-start), var(--card-bg-end));
            max-width: 800px;
            width: 90%;
            padding: 1.5rem;
            margin: 1rem auto;
            border-radius: 15px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), transparent);
            z-index: 0;
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
            transform: scale(1.03);
        }

        .card > * {
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--primary-color);
            letter-spacing: -0.02em;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border: 2px solid var(--border-color);
            margin-top: 1.5rem;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: center;
            font-size: 0.95rem;
            vertical-align: middle;
            border-bottom: 2px solid var(--border-color);
        }

        th {
            background: linear-gradient(to right, var(--table-header), var(--table-header-end));
            color: var(--text-color);
            font-weight: 600;
            width: 16.66%;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        td {
            background: #ffffff;
            color: #1f2937;
            width: 16.66%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background 0.2s ease;
        }

        tr:hover td {
            background: rgba(240, 234, 247, 0.7);
            transform: translateY(-2px);
        }

        .status-badge {
            display: inline-flex;
            padding: 0.3rem 0.8rem;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-active {
            background-color: #D1E7DD;
            color: #0F5132;
        }

        .status-completed {
            background-color: #E9ECEF;
            color: var(--primary-color);
        }

        .status-paused {
            background-color: #FFF3CD;
            color: #856404;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            padding: 0.85rem 1.75rem;
            background: linear-gradient(135deg, #5A67D8 0%, #4C51BF 100%);
            color: var(--text-color);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease, background 0.4s ease;
            margin: 2rem auto 0;
            overflow: hidden;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #4C51BF 0%, #434190 100%);
            transform: scale(1.06);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
        }

        .back-button:active {
            transform: scale(0.98);
        }

        .back-button svg {
            width: 1.2rem;
            height: 1.2rem;
            margin-right: 0.6rem;
            transition: transform 0.3s ease;
        }

        .back-button:hover svg {
            transform: translateX(-3px);
        }

        @media (max-width: 640px) {
            .card {
                padding: 1rem;
                width: 95%;
                margin: 0.5rem auto;
            }

            h1 {
                font-size: 1.8rem;
                margin-bottom: 1.5rem;
            }

            table {
                margin-top: 1rem;
            }

            th, td {
                font-size: 0.8rem;
                padding: 0.75rem;
            }

            .back-button {
                padding: 0.75rem 1.5rem;
                margin: 1.5rem auto 0;
            }

            .back-button svg {
                width: 1rem;
                height: 1rem;
                margin-right: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Countdown History</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Created At</th>
                    <th>End Time</th>
                    <th>Status</th>
                    <th>Remaining (sec)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($error)) {
                    echo "<tr><td colspan='6' class='px-6 py-4 text-center text-red-600'>$error</td></tr>";
                } elseif (!isset($user_id) || $user_id === null) {
                    echo "<tr><td colspan='6' class='px-6 py-4 text-center text-red-600'>Please log in to view your countdown history.</td></tr>";
                } elseif (empty($countdowns)) {
                    echo "<tr><td colspan='6' class='px-6 py-4 text-center text-gray-500'>No countdown history found.</td></tr>";
                } else {
                    foreach ($countdowns as $countdown) {
                        $statusClass = $countdown['status'] === 'active' ? 'status-active' : 
                                      ($countdown['status'] === 'completed' ? 'status-completed' : 
                                      'status-paused');
                        echo "
                        <tr>
                            <td>" . htmlspecialchars($countdown['countdown_name'] ?? 'Unnamed') . "</td>
                            <td>" . htmlspecialchars($countdown['duration']) . "</td>
                            <td>" . htmlspecialchars($countdown['created_at']) . "</td>
                            <td>" . htmlspecialchars($countdown['end_time'] ?? '-') . "</td>
                            <td>
                                <span class='status-badge $statusClass'>
                                    " . ucfirst(htmlspecialchars($countdown['status'])) . "
                                </span>
                            </td>
                            <td>" . htmlspecialchars($countdown['remaining_time'] ?? '-') . "</td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="countdown_form.php" class="back-button" aria-label="Return to create countdown page">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Create Countdown
            </a>
        </div>
    </div>
</body>
</html>