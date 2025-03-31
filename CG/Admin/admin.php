<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   School Guidance and Records Management System
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
 </head>
 <body class="font-roboto bg-gray-100">
  <div class="flex h-screen">
   <!-- Sidebar -->
   <div class="w-64 bg-blue-900 text-white flex flex-col">
    <div class="p-4 text-center text-2xl font-bold border-b border-blue-800">
     SGRMS
    </div>
    <nav class="flex-1 p-4">
     <ul>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-tachometer-alt mr-3">
        </i>
        Dashboard
       </a>
      </li>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-user-graduate mr-3">
        </i>
        Students
       </a>
      </li>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-chalkboard-teacher mr-3">
        </i>
        Teachers
       </a>
      </li>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-calendar-alt mr-3">
        </i>
        Appointments
       </a>
      </li>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-file-alt mr-3">
        </i>
        Reports/Cases
       </a>
      </li>
      <li class="mb-4">
       <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
        <i class="fas fa-cogs mr-3">
        </i>
        Settings
       </a>
      </li>
     </ul>
    </nav>
    <div class="p-4 border-t border-blue-800">
     <a class="flex items-center p-2 hover:bg-blue-800 rounded" href="#">
      <i class="fas fa-sign-out-alt mr-3">
      </i>
      Logout
     </a>
    </div>
   </div>
   <!-- Main Content -->
   <div class="flex-1 p-6">
    <header class="flex justify-between items-center mb-6">
     <h1 class="text-3xl font-bold">
      Dashboard
     </h1>
     <div class="flex items-center">
      <img alt="Profile picture of the guidance counselor" class="rounded-full mr-4" height="40" src="https://storage.googleapis.com/a1aa/image/A9RXZGmwlLaRd6kev93t1RlcsSZsyBKmbl-Xc-Siqcs.jpg" width="40"/>
      <span class="font-medium">
       John Doe
      </span>
     </div>
    </header>
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
     <div class="bg-white p-4 rounded shadow">
      <h2 class="text-xl font-bold mb-2">
       Total Students
      </h2>
      <p class="text-3xl">
       1,234
      </p>
     </div>
     <div class="bg-white p-4 rounded shadow">
      <h2 class="text-xl font-bold mb-2">
       Upcoming Appointments
      </h2>
      <p class="text-3xl">
       12
      </p>
     </div>
     <div class="bg-white p-4 rounded shadow">
      <h2 class="text-xl font-bold mb-2">
       Pending Reports/Cases
      </h2>
      <p class="text-3xl">
       5
      </p>
     </div>
    </section>
    <section class="bg-white p-6 rounded shadow">
     <h2 class="text-2xl font-bold mb-4">
      Recent Appointments
     </h2>
     <div class="space-y-4">
      <div class="flex items-center justify-between p-4 bg-gray-100 rounded">
       <div>
        <h3 class="text-lg font-bold">
         Jane Smith
        </h3>
        <p class="text-sm text-gray-600">
         2023-10-01 at 10:00 AM
        </p>
       </div>
       <span class="px-3 py-1 bg-blue-500 text-white rounded">
        Scheduled
       </span>
      </div>
      <div class="flex items-center justify-between p-4 bg-gray-100 rounded">
       <div>
        <h3 class="text-lg font-bold">
         John Doe
        </h3>
        <p class="text-sm text-gray-600">
         2023-10-02 at 11:00 AM
        </p>
       </div>
       <span class="px-3 py-1 bg-green-500 text-white rounded">
        Completed
       </span>
      </div>
      <div class="flex items-center justify-between p-4 bg-gray-100 rounded">
       <div>
        <h3 class="text-lg font-bold">
         Alice Johnson
        </h3>
        <p class="text-sm text-gray-600">
         2023-10-03 at 1:00 PM
        </p>
       </div>
       <span class="px-3 py-1 bg-blue-500 text-white rounded">
        Scheduled
       </span>
      </div>
      <div class="flex items-center justify-between p-4 bg-gray-100 rounded">
       <div>
        <h3 class="text-lg font-bold">
         Bob Brown
        </h3>
        <p class="text-sm text-gray-600">
         2023-10-04 at 2:00 PM
        </p>
       </div>
       <span class="px-3 py-1 bg-red-500 text-white rounded">
        Cancelled
       </span>
      </div>
      <div class="flex items-center justify-between p-4 bg-gray-100 rounded">
       <div>
        <h3 class="text-lg font-bold">
         Emily Davis
        </h3>
        <p class="text-sm text-gray-600">
         2023-10-05 at 3:00 PM
        </p>
       </div>
       <span class="px-3 py-1 bg-blue-500 text-white rounded">
        Scheduled
       </span>
      </div>
     </div>
    </section>
   </div>
  </div>
 </body>
</html>