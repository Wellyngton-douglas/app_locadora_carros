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
									<input type="number" class="form-control" id="inputId" aria-describedby="idHelp" placeholder="Número" v-model="busca.id">
								</input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="nomeHelp" titulo="Nome" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome da Marca">
                                <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome da marca" v-model="busca.nome">
								</input-container-component>
                            </div>
                        </div>
                    </template>

					<template v-slot:rodape>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="submit" class="btn btn-primary" @click="pesquisar()">Pesquisar</button>
						</div>
                    </template>
				</card-component>
				<!-- Fim card busca -->

				<!-- Inicio card listagem-->
				<card-component titulo="Relatório de Marcas">
                    <template v-slot:conteudo>
                        <table-component 
							:dados="marcas.data"
							:botoes="botoes"
							:titulos="titulos"></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
							<div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in marcas.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
							<div class="d-grid gap-2 d-md-flex justify-content-md-end">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMarca">Adicionar</button>
							</div>
						</div>
                    </template>
                </card-component>
				<!-- Fim card listagem-->
			</div>
		</div>

		<!-- Inicio modal adicionar -->
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
		<!-- Fim modal adicionar -->

		<!-- Inicio modal visualizar -->
		<modal-component id="modalMarcaVisualizar" title="Visualizar Marca">
			<template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a marca" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
			<template v-slot:conteudo>
				<!-- <div class="form">
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
				</div> -->
			</template>
			<template v-slot:rodape>
				<div class="d-grid gap-2 d-md-flex justify-content-md-end">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<!-- <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button> -->
				</div>
			</template>
		</modal-component>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				urlBase: 'http://localhost:8000/api/v1/marca',
				urlPaginacao: '',
				urlFiltro: '',
				nomeMarca: '',
				arquivoImagem: [],
                transacaoStatus: '',
                transacaoDetalhes: {},
				marcas: { data: [] },
				titulos: {
					id: {titulo: 'Número', tipo: 'texto'},
					nome: {titulo: 'Nome', tipo: 'texto'},
					imagem: {titulo: 'Imagem', tipo: 'imagem'},
					created_at: {titulo: 'Data de Criação', tipo: 'data'},
				},
				busca: { id: '', nome: '' },
				botoes: {
					atualizar: {visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar'},
					visualizar: {visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar'},
					remover: {visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover'},
				}
			}
		},
		methods: {
			pesquisar() {
				let filtro = ''

				for(let chave in this.busca) {
					if(this.busca[chave] != '') {
						if(filtro != '') {
							filtro += ";"
						}
	
						filtro += chave + ':like:' + this.busca[chave]
					}
				}

				if(filtro != '') {
					this.urlPaginacao = 'page=1'
					this.urlFiltro = '&filtro=' + filtro
				} else {
					this.urlFiltro = ''
				}

				this.carregarLista()

			},
			paginacao(l) {
                if(l.url) {
                    this.urlPaginacao = l.url.split('?')[1] //retornando a paginação que foi clicada
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
			carregarLista() {
				let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
				console.log(url)
				axios.get(url)
					.then(response => {
						this.marcas = response.data
						console.log(this.marcas)
					})
					.catch(errors => {
						console.log(errors)
					})
			},
			carregarImagem(event) {
				this.arquivoImagem = event.target.files
			},
			salvar() {
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
		},
		mounted() {
			this.carregarLista()
		}
	}
</script>
