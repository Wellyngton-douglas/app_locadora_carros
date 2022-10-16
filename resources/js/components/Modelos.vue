<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Inicio card busca -->
                <card-component titulo="Busca Modelos">
					<template v-slot:conteudo>
                        <div class="row">
                            <div class="col mb-3">
								<input-container-component id="inputMarcaId" titulo="Número da Marca" id-help="MarcaIdHelp" texto-ajuda="Opcional. Informe o Número da Marca">
									<input type="number" class="form-control" id="inputMarcaId" aria-describedby="MarcaIdHelp" placeholder="Número da Marca" v-model="busca.marca_id">
								</input-container-component>
                            </div>
                            <div class="col mb-3">
                                <input-container-component id="nomeHelp" titulo="Nome do Modelo" id-help="nomeHelp" texto-ajuda="Opcional. Informe o Nome do Modelo">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp" placeholder="Nome do Modelo" v-model="busca.nome">
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
				<card-component titulo="Relatório de Modelos">
                    <template v-slot:conteudo>
                        <table-component 
							:dados="modelos.data"
							:botoes="botoes"
							:titulos="titulos">
                        </table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
							<div class="col-10">
                                <paginate-component>
                                    <li v-for="l, key in modelos.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </paginate-component>
                            </div>
							<div class="col">
								<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalModelo">Adicionar</button>
							</div>
						</div>
                    </template>
                </card-component>
				<!-- Fim card listagem-->

                <!-- Inicio modal adicionar -->
				<modal-component id="modalModelo" title="Adicionar Marca">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Cadastro realizado com sucesso" v-if="$store.state.transacao.status == 'adicionado'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro ao tentar cadastrar a marca" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'adicionado'">
						<div class="form">
							<div class="col mb-3">
								<input-container-component id="novoNome" titulo="Nome da Marca" id-help="novoNomeHelp" texto-ajuda="Informe o Nome da Marca">
                                    <select v-model="marca_id" class="form-select" aria-label="Default select example" @click="carregarListaMarca()">
                                        <option value="" disabled>Escolha uma Marca</option>
                                        <option v-for="marca in marcas" :key="marca.id" :value="marca.id">
                                            {{ marca.nome }}
                                        </option>
                                    </select>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novoNome" titulo="Nome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Modelo">
									<input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome" v-model="nome">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="numeroPortas" titulo="Número de Portas" id-help="numeroPortasHelp" texto-ajuda="Informe a quantidade de Portas">
                                    <input type="number" class="form-control" name="numeroPortas" min="1" max="4" v-model="numeroPortas">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="numeroLugares" titulo="Número de Lugares" id-help="numeroLugaresHelp" texto-ajuda="Informe a quantidade de Lugares">
                                    <input type="number" class="form-control" name="numeroLugares" min="1" max="8" v-model="lugares">
                                </input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="airBag" titulo="AirBag" id-help="airBagHelp" texto-ajuda="Informe se tem Airbag">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="airBag" id="airBag1" v-model="airBag" checked>
                                    <label class="form-check-label" for="airBag1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="airBag" id="airBag2" v-model="airBag">
                                    <label class="form-check-label" for="airBag2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="abs" titulo="Freio ABS" id-help="absHelp" texto-ajuda="Informe se tem Freio ABS">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="abs" id="abs1" v-model="abs" checked>
                                    <label class="form-check-label" for="abs1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="abs" id="abs2" v-model="abs">
                                    <label class="form-check-label" for="abs2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novaImagem" titulo="Imagem" id-help="novaImagemHelp" texto-ajuda="Informe a Imagem do Modelo">
									<input type="file" class="form-control" id="novaImagem" aria-describedby="novaImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
								</input-container-component>
							</div>
						</div>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-primary" @click="salvar()" v-if="$store.state.transacao.status != 'adicionado'">Salvar</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal adicionar -->

                <!-- Inicio modal remover -->
				<modal-component id="modalModeloRemover" title="Remover Marca">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
						<input-container-component titulo="Número Marca">
							<input type="text" class="form-control" :value="$store.state.item.marca_id" disabled>
						</input-container-component>

						<input-container-component titulo="Nome do Modelo">
							<input type="text" class="form-control" :value="$store.state.item.nome" disabled>
						</input-container-component>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal remover -->

                <!-- Inicio modal atualizar -->
				<modal-component id="modalModeloAtualizar" title="Atualizar Marca">
					<template v-slot:alertas>
						<alert-component tipo="success" :detalhes="$store.state.transacao" titulo="Transação realizada com sucesso" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
						<alert-component tipo="danger" :detalhes="$store.state.transacao" titulo="Erro na transação" v-if="$store.state.transacao.status == 'erro'"></alert-component>
					</template>
					<template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
						<div class="form">
							<div class="col mb-3">
								<input-container-component id="novoNome" titulo="Nome da Marca" id-help="novoNomeHelp" texto-ajuda="Informe o Nome da Marca">
                                    <select v-model="$store.state.item.marca_id" class="form-select" aria-label="Default select example" @click="carregarListaMarca()">
                                        <option value="" disabled>Escolha uma Marca</option>
                                        <option v-for="marca in marcas" :key="marca.id" :value="marca.id">
                                            {{ marca.nome }}
                                        </option>
                                    </select>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="novoNome" titulo="Nome" id-help="novoNomeHelp" texto-ajuda="Informe o Nome do Modelo">
									<input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp" placeholder="Nome" v-model="$store.state.item.nome">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="numeroPortas" titulo="Número de Portas" id-help="numeroPortasHelp" texto-ajuda="Informe a quantidade de Portas">
                                    <input type="number" class="form-control" name="numeroPortas" min="1" max="4" v-model="$store.state.item.numero_portas">
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="numeroLugares" titulo="Número de Lugares" id-help="numeroLugaresHelp" texto-ajuda="Informe a quantidade de Lugares">
                                    <input type="number" class="form-control" name="numeroLugares" min="1" max="8" v-model="$store.state.item.lugares">
                                </input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="airBag" titulo="AirBag" id-help="airBagHelp" texto-ajuda="Informe se tem Airbag">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="airBag" id="airBag1" v-model="$store.state.item.air_bag" checked>
                                    <label class="form-check-label" for="airBag1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="airBag" id="airBag2" v-model="$store.state.item.air_bag">
                                    <label class="form-check-label" for="airBag2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="abs" titulo="Freio ABS" id-help="absHelp" texto-ajuda="Informe se tem Freio ABS">
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=1 type="radio" name="abs" id="abs1" v-model="$store.state.item.abs" checked>
                                    <label class="form-check-label" for="abs1">
                                        Sim
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" value=0 type="radio" name="abs" id="abs2" v-model="$store.state.item.abs">
                                    <label class="form-check-label" for="abs2">
                                        Não
                                    </label>
                                </div>
								</input-container-component>
							</div>
                            <div class="col mb-3">
								<input-container-component id="atualizarImagem" titulo="Imagem" id-help="atualizarImagemHelp" texto-ajuda="Informe a Imagem do Modelo">
									<input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp" placeholder="Imagem" @change="carregarImagem($event)">
								</input-container-component>
							</div>
						</div>
					</template>
					<template v-slot:rodape>
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
							<button type="button" class="btn btn-primary" @click="atualizar()" v-if="$store.state.transacao.status != 'sucesso'">Salvar</button>
						</div>
					</template>
				</modal-component>
				<!-- Fim modal atualizar -->
                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
				urlBase: this.$store.state.configUrl.modelos,
				urlPaginacao: '',
				urlFiltro: '',
                modelos: { data: [] },
                marcas: { data: [] },
                titulos: {
                    id: {titulo: 'Número Modelo', tipo: 'texto'},
					marca_id: {titulo: 'Número Marca', tipo: 'texto'},
					nome: {titulo: 'Nome', tipo: 'texto'},
					imagem: {titulo: 'Imagem', tipo: 'imagem'},
                    numero_portas: {titulo: 'Portas', tipo: 'texto'},
                    lugares: {titulo: 'Lugares', tipo: 'texto'},
                    air_bag: {titulo: 'AirBag', tipo: 'condicao'},
                    abs: {titulo: 'Abs', tipo: 'condicao'},
					created_at: {titulo: 'Data de Criação', tipo: 'data'},
				},
                botoes: {
					atualizar: {visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloAtualizar'},
					remover: {visivel: true, dataToggle: 'modal', dataTarget: '#modalModeloRemover'},
				},
                marca_id: '',
                nome: '',
                arquivoImagem: [],
                numeroPortas: '',
                lugares: '',
                airBag: 1,
                abs: 1,
                busca: { marca_id: '', nome: '' }
            }
        },
        methods: {
            carregarLista() {
				let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
				axios.get(url)
					.then(response => {
						this.modelos = response.data
						//console.log(this.modelos)
					})
					.catch(errors => {
						console.log(errors)
					})
			},
            carregarListaMarca() {
                let url = this.$store.state.configUrl.marcas
                axios.get(url)
					.then(response => {
						this.marcas = response.data.data
						console.log(response.data.data)
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
				formData.append('marca_id', this.marca_id)
				formData.append('nome', this.nome)
                formData.append('imagem', this.arquivoImagem[0])
                formData.append('numero_portas', this.numeroPortas)
                formData.append('lugares', this.lugares)
                formData.append('air_bag', this.airBag)
                formData.append('abs', this.abs)
                
				let config = {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}

				axios.post(this.urlBase, formData, config)
					.then(response => {
                        this.$store.state.transacao.status = 'adicionado'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
						console.log(response)
					})
					.catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
						console.log(errors)
					})				
			},
			paginacao(l) {
                if(l.url) {
                    this.urlPaginacao = l.url.split('?')[1] //retornando a paginação que foi clicada
                    this.carregarLista() //requisitando novamente os dados para nossa API
                }
            },
            remover() {
                let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

                if(!confirmacao) {
                    return false;
                }

                let formData = new FormData();
                formData.append('_method', 'delete')

                let url = this.urlBase + '/' + this.$store.state.item.id

                axios.post(url, formData)
                    .then(response => {
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = response.data.msg
                        this.carregarLista()
                    })
                    .catch(errors => {
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })

            },
            atualizar() {
                let formData = new FormData();
                formData.append('_method', 'patch')
                formData.append('marca_id', this.$store.state.item.marca_id)
				formData.append('nome', this.$store.state.item.nome)
                formData.append('numero_portas', this.$store.state.item.numero_portas)
                formData.append('lugares', this.$store.state.item.lugares)
                formData.append('air_bag', this.$store.state.item.air_bag)
                formData.append('abs', this.$store.state.item.abs)

				if(this.arquivoImagem[0]) {
                    formData.append('imagem', this.arquivoImagem[0])
                }

                let url = this.urlBase + '/' + this.$store.state.item.id

                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }

                axios.post(url, formData, config)
                    .then(response => {
                        console.log('Atualizado', response)
                        atualizarImagem.value = ''
                        this.$store.state.transacao.status = 'sucesso'
                        this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso'
                        this.carregarLista()
                    })
                    .catch(errors => {
                        console.log('Erro de atualização', errors.response)
                        this.$store.state.transacao.status = 'erro'
                        this.$store.state.transacao.mensagem = errors.response.data.message
                        this.$store.state.transacao.dados = errors.response.data.errors
                    })
            },
            pesquisar() {
				let filtro = ''

				for(let chave in this.busca) {
					if(this.busca[chave] != '') {
						if(filtro != '') {
							filtro += ";"
						}
	
						filtro += chave + ':like:%' + this.busca[chave] + '%'
					}
				}

				if(filtro != '') {
					this.urlPaginacao = 'page=1'
					this.urlFiltro = '&filtro=' + filtro
				} else {
					this.urlFiltro = ''
				}

				this.carregarLista()

			}
        },
        mounted() {
            this.carregarLista(),
            this.carregarListaMarca()
        }
    }
</script>
