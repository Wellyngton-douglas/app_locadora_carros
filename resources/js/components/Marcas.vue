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
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
						</div>
                    </template>
                </card-component>
				<!-- Fim card listagem-->

			</div>
		</div>
		<modal-component id="modalMarca" title="Adicionar Marca">
			<template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
			<template v-slot:conteudo>
				<div class="form">
					<div class="col mb-3">
						<input-container-component id="novoNome" titulo="Nome da Marca" id-help="novoNomeHelp" texto-ajuda="Informe o Nome da Marca">
							<input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome da Marca" v-model="nomeMarca">
						</input-container-component>
					</div>
					<div class="col mb-3">
						<input-container-component id="novaImagem" titulo="Imagem" id-help="novaImagemHelp" texto-ajuda="Informe a Imagem da Marca">
							<input type="file" class="form-control" id="novaImagem" aria-describedby="novaImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
						</input-container-component>
					</div>
				</div>
			</template>
			<template v-slot:rodape>
				<div class="d-grid gap-2 d-md-flex justify-content-md-end">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
				</div>
			</template>
		</modal-component>
	</div>
</template>

<script>
import axios from 'axios'

	export default {
		data() {
			return {
				urlBase: 'http://localhost:8000/api/v1/marca',
				nomeMarca: '',
				arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {}
			}
		},
		methods: {
			carregarImagem(event) {
				this.arquivoImagem = event.target.files
			},
			salvar() {
				console.log(this.nomeMarca, this.arquivoImagem)

				let formData = new FormData();
				formData.append('nome', this.nomeMarca)
				formData.append('imagem', this.arquivoImagem[0])

				let config = {
					headers: {
						'Content-Type': 'multipart/form-data',
						'Accept': 'application/json'
					}
				}

				axios.post(this.urlBase, formData, config)
					.then(response => {
                        this.transacaoStatus = 'adicionado'
                        this.transacaoDetalhes = {
							mensagem: 'Número da Marca: ' + response.data.id
						}
						console.log(response)
					})
					.catch(errors => {
                        this.transacaoStatus = 'erro'
                        this.transacaoDetalhes = {
							mensagem: errors.response.data.message,
							dados: errors.response.data.errors
						}
						//errors.response.data.message a mensagem do erro
						console.log(errors)
					})				
			}
		}
	}
</script>
