<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">

				<!-- Inicio card busca -->
				<card-component titulo="Busca marcas">
					<template v-slot:conteudo>
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
                    </template>

					<template v-slot:rodape>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" class="btn btn-primary">Pesquisar</button>
						</div>
                    </template>
				</card-component>
				<!-- Fim card busca -->

				<!-- Inicio card listagem-->
				<card-component titulo="Relatório de Marcas">
                    <template v-slot:conteudo>
                        <table-component></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-primary">Adicionar</button>
						</div>
                    </template>
                </card-component>
				<!-- Fim card listagem-->

			</div>
		</div>
	</div>
</template>

<script>
</script>
