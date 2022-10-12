<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">

				<!-- Inicio card busca -->
				<div class="card mb-3">
					<div class="card-header">Buscar Marcas</div>

					<div class="card-body">
                        <div class="row">
                            <div class="col mb-3">
								<input-container-component id="inputId" titulo="Número" id-help="idHelp" texto-ajuda="Opcional. Informe o Número do registro">
									<input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Número">
								</input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="nomeHelp" titulo="Nome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome da Marca">
                                <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca">
								</input-container-component>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</div>
                    </div>
				</div>
				<!-- Fim card busca -->

				<!-- Inicio card listagem-->
				<div class="card">
					<div class="card-header">Relatório de Marcas</div>

					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
								<th scope="col">#</th>
								<th scope="col">First</th>
								<th scope="col">Last</th>
								<th scope="col">Handle</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
								</tr>
								<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
								</tr>
								<tr>
								<th scope="row">3</th>
								<td colspan="2">Larry the Bird</td>
								<td>@twitter</td>
								</tr>
							</tbody>
						</table>
                    </div>

                    <div class="card-footer">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-primary">Adicionar</button>
						</div>
                    </div>
				</div>
				<!-- Fim card listagem-->

			</div>
		</div>
	</div>
</template>

<script>
</script>
