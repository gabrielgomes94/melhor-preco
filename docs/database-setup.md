# Database Setup

1. Defina o token do Bling na env var: `BLING_API_KEY`
```
Vá em: Configurações -> Sistemas -> Usuários e API.
Selecione o Usuário com API. 
Copie o token em API Key
Cole no arquivo .env 
```

2. Sincronize as categorias

3. Configure os Marketplaces

```
2.1. Vá em: Configurações -> Integrações -> Configurações de integração com lojas virtuais e marketplaces
Selecione um Marketplace
Copie o campo 'Código da Loja API BLing'. 

2.2. No Melhor Preço, vá em Marketplaces -> Adicionar novo Marketplace
Cole o ID do Usuário no campo. 
Defina o nome.
Defina o tipo de comissão. 
Defina o status.

```


4. Suba a fila: ``php artisan queue:listen --timeout=600``
   
5. Sincronize os dados
```
No Melhor Preço, vá em Dashboard.
Aperte o botão sincronizar. 
```
