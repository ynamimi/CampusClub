<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $club->name }} - Official Activity Report</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        /* Report Container */
        .report-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border: 1px solid #e1e1e1;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e1e1e1;
        }

        /* NEW: Image container for centering multiple images */
        .header-images {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px; /* Space below images */
        }

        .header-images img {
            max-height: 80px; /* Adjust size as needed */
            margin: 0 10px; /* Space between images */
        }
        /* END NEW */

        .logo {
            max-width: 120px;
            margin-bottom: 15px;
        }

        .report-title {
            color: #2c3e50;
            margin: 10px 0 5px;
            font-size: 24px;
            font-weight: 600;
        }

        .report-subtitle {
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .report-meta {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Section Styles */
        .section {
            margin-bottom: 30px;
        }

        .section-title {
            color: #3498db;
            font-size: 18px;
            font-weight: 600;
            margin: 25px 0 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #3498db;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        th {
            background-color: #3498db;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-weight: 500;
        }

        td {
            padding: 10px 15px;
            border-bottom: 1px solid #e1e1e1;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Info Blocks */
        .info-block {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
        }

        .info-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e1e1e1;
            font-size: 12px;
            color: #7f8c8d;
            text-align: center;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-0 { margin-bottom: 0; }

        .signature-block {
            text-align: center; /* Center content within the block */
        }
        .signature-block p {
            margin: 0; /* Remove default paragraph margins */
            padding: 0; /* Remove default paragraph padding */
        }
        .signature-line {
            margin-top: 40px; /* Space for the signature line */
            margin-bottom: 5px; /* Space between line and name */
            display: inline-block; /* Treat as block but allow centering */
            width: 80%; /* Or a fixed width, e.g., 200px */
            border-bottom: 1px solid #000; /* The actual line */
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="header">
            <div class="header-images">
                <img src="{{ public_path('images/logo.uitm.png') }}" alt="University Logo">
            </div>
            <h1 class="report-title">{{ $club->name }} Activity Report</h1>
            <p class="report-subtitle">Official Report for Student Affair Department</p>
            <p class="report-meta">Generated on: {{ now()->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <!-- Activity Details Section -->
        <div class="section">
            <h2 class="section-title">Activity Details</h2>

            <table>
                <tr>
                    <th width="25%">Event Name</th>
                    <td>{{ $activity->name }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $activity->event_date->format('F j, Y (l)') }}</td>
                </tr>
                <tr>
                    <th>Time</th>
                    <td>{{ \Carbon\Carbon::parse($activity->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($activity->end_time)->format('g:i A') }}</td>
                </tr>
                <tr>
                    <th>Organizing Committee</th>
                    <td>{{ $club->name }} Executive Committee</td>
                </tr>
                <tr>
                    <th>Venue</th>
                    <td>{{ $activity->venue }}</td>
                </tr>
                @if($activity->poster)
                <tr>
                    <th>Event Poster</th>
                    <td>
                        <img src="{{ storage_path('app/public/' . $activity->poster) }}" width="200" style="border: 1px solid #ddd; padding: 5px;">
                    </td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Objectives Section -->
        <div class="section">
            <div class="info-block">
                <h3 class="info-title">Objectives</h3>
                <p>{{ $activity->objectives }}</p>
            </div>
        </div>

        <!-- Activities Plan Section -->
        <div class="section">
            <div class="info-block">
                <h3 class="info-title">Activities Plan</h3>
                <p>{{ $activity->activities }}</p>
            </div>
        </div>

        <!-- Participants Section -->
        <div class="section">
            <h2 class="section-title">Participants ({{ $activity->registrations->count() }})</h2>

            @if($activity->registrations->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="25%">Name</th>
                            <th width="15%">Student ID</th>
                            <th width="25%">Course</th>
                            <th width="10%">Semester</th>
                            <th width="20%">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($club->registrations as $index => $registration)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $registration->fullname }}</td>
                            <td>{{ $registration->student_id }}</td>
                            <td>{{ $registration->course }}</td>
                            <td>{{ $registration->semester }}</td>
                            <td>{{ $registration->phone ?? 'N/A' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="info-block">
                    <p>No participants registered for this event.</p>
                </div>
            @endif
        </div>

        <!-- Approval Section -->
        <div class="section">
            <table style="margin-top: 40px;">
                <tr>
                    <td width="50%" style="border-bottom: 1px solid #e1e1e1; padding: 30px 15px;">
                        <div class="signature-block">
                            <p class="mb-0">Prepared by:</p>
                            <div class="signature-line"></div>
                            <p>Club President</p>
                            <p>{{ $club->name }}</p>
                        </div>
                    </td>
                    <td width="50%" style="border-bottom: 1px solid #e1e1e1; padding: 30px 15px;">
                        <div class="signature-block">
                            <p class="mb-0">Approved by:</p>
                            <div class="signature-line"></div>
                            <p>{{ $club->advisor_name ?? 'Dr. Advisor Name' }}</p>
                            <p>Club Advisor</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>This is an official document generated by the {{ $club->name }} management system.</p>
        </div>
    </div>
</body>
</html>
