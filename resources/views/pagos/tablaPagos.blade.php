 {{-- Listado de Conceptos --}}
 <div class="conceptos-registrados">
     <div class="table-container">
         <!-- Selector de registros por página - PARTE SUPERIOR -->
         <div class="pagination-top">
             <div class="pagination-selector_pago">
                 <label for="registros-select_pago">Mostrar:</label>
                 <select id="registros-select_pago" class="registros-select_pago">
                     <option value="5" selected>5</option>
                     <option value="10">10</option>
                     <option value="20">20</option>
                     <option value="50">50</option>
                     <option value="100">100</option>
                     <option value="all">Todos</option>
                 </select>
                 <span>registros</span>
             </div>
         </div>

         <!-- Spinner de carga -->
         <div id="loading-spinner_pago" class="spinner-container">
             <div class="spinner"></div>
         </div>


         <table class="conceptos-table" id="pagos-table">
             <thead>
                 <tr>
                     <th>BOMBRE</th>
                     <th>MONTO</th>
                     <th>FECHA</th>
                     <th>REPETICIÓN</th>
                     <th>METODO DE PAGO</th>
                     <th>ESTADO</th>
                     <th>ACCIONES</th>
                 </tr>
             </thead>
             <tbody id="pagos-tbody">
             </tbody>
         </table>
         <!-- Controles de paginación inferior -->
         <div id="pagination-controls_pago" class="pagination-controls_pago"></div>
     </div>
 </div>
