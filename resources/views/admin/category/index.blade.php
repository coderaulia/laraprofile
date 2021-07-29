<x-app-layout>
   <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
         Hi, <strong>{{ Auth::user()->name }}!</strong>
      </h2>
   </x-slot>

   <div class="py-12">

      <div class="container">
         <div class="row">
            <table class="table">
               <thead>
                  <tr>
                     <th scope="col">No</th>
                     <th scope="col">Category Name</th>
                     <th scope="col">Email</th>
                     <th scope="col">Created at</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <th scope="row"></th>
                     <td></td>
                     <td></td>
                     <td></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</x-app-layout>