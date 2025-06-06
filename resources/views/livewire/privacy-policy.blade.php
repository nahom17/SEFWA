@extends('components.layouts.app')

@section('content')


@php

$date = date('l jS \of F Y h:i:s A');
@endphp

<div>

    <h1>Privacy Policy for NahomApp</h1>
                <p><strong>Effective Date:</strong>{{ $date}}</p>
                <h2>1. Introduction</h2>
                <p>Welcome to NahomApp! This Privacy Policy describes how NahomApp ("we," "us," or "our"), a mobile application developed and operated by Nahom Tesfamichael ("I," "me," or "my"), a self-employed developer, collects, uses, shares, and protects information in connection with your use of the NahomApp mobile application (NahomApp).</p>
                <p>I am committed to protecting your privacy and ensuring that your personal information is handled responsibly. This Privacy Policy explains what information I collect, how I use it, and your rights regarding your information.</p>
                <h2>2. Information I Collect</h2>
                <p>As a self-employed developer, I strive to minimize the collection of personal information. NahomApp may collect the following types of information:</p>
                <ul>
                    <li><strong>Non-Personal Information:</strong>
                        <ul>
                            <li><strong>Usage Data:</strong> I may collect non-personal information about how you use the App, such as the features you use, the time and duration of your sessions, and the screens you visit. This information is used to improve the App's functionality and user experience.</li>
                            <li><strong>Device Information:</strong> I may collect information about the device you use to access the App, such as the device type, operating system, and unique device identifiers. This information helps me optimize the App for different devices.</li>
                            <li><strong>Error logs:</strong> I may collect error logs to help me fix bugs and improve the app.</li>
                        </ul>
                    </li>
                    <li><strong>Information from API:</strong>
                        <ul>
                            <li>The app uses an API hosted on nahomapp.com to retrieve data about players, clubs, and other related information. This data is not considered personal data.</li>
                        </ul>
                    </li>
                </ul>
                <h2>3. How I Use Your Information</h2>
                <p>I use the information collected for the following purposes:</p>
                <ul>
                    <li><strong>To Provide and Improve the App:</strong> I use the information to operate, maintain, and improve the App's features and functionality.</li>
                    <li><strong>To Analyze Usage:</strong> I use usage data to understand how users interact with the App, which helps me identify areas for improvement.</li>
                    <li><strong>To Fix Bugs:</strong> I use error logs to fix bugs and improve the app.</li>
                    <li><strong>To Communicate:</strong> I may use your information to respond to your inquiries or provide support.</li>
                </ul>
                <h2>4. Sharing of Information</h2>
                <p>As a self-employed developer, I do not sell, trade, or rent your personal information to third parties. I may share information in the following limited circumstances:</p>
                <ul>
                    <li><strong>Service Providers:</strong> I may use third-party service providers to assist with app analytics, error tracking, or other services. These providers are contractually obligated to protect your information and use it only for the purposes I specify.</li>
                    <li><strong>Legal Requirements:</strong> I may disclose information if required to do so by law or in response to a valid legal request, such as a subpoena or court order.</li>
                    <li><strong>Protection of Rights:</strong> I may disclose information if I believe it is necessary to protect my rights, property, or safety, or the rights, property, or safety of others.</li>
                </ul>
                <h2>5. Data Security</h2>
                <p>I take reasonable measures to protect the information collected through the App from unauthorized access, use, or disclosure. However, no method of transmission over the internet or method of electronic storage is completely secure, and I cannot guarantee absolute security.</p>
                <h2>6. Data Retention</h2>
                <p>I will retain your information for as long as necessary to fulfill the purposes outlined in this Privacy Policy unless a longer retention period is required or permitted by law.</p>
                <h2>7. Children's Privacy</h2>
                <p>NahomApp is not intended for use by children under the age of 13. I do not knowingly collect personal information from children under 13. If I become aware that I have collected personal information from a child under 13, I will take steps to delete it.</p>
                <h2>8. Your Rights</h2>
                <p>You have the following rights regarding your information:</p>
                <ul>
                    <li><strong>Access:</strong> You have the right to request access to the information I have collected about you.</li>
                    <li><strong>Correction:</strong> You have the right to request that I correct any inaccurate or incomplete information about you.</li>
                    <li><strong>Deletion:</strong> You have the right to request that I delete your information
</div>
@endsection()
