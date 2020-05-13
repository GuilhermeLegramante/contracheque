
## NFS-e
Sistema de emissão de Notas Fiscais de Serviços

### Funcionalidades implementadas
- CRUD Prestador
- CRUD Tomador
- Login com Perfis de acesso (Fiscal e Prestador)
- Emissão de NFS-e 

### Tecnologias
- Laravel
- MySQL
- DOMPdf (relatórios pdf)
- AdminLTE (Dashboard)

### Níveis de Acesso
#### Prestador
- Emissão de NFS-e
- Visualização e emissão de relatórios

#### Fiscal
- Cadastro de Prestadores
- Cadastro de Tomadores
- Visualização de emissão de relatórios

#### Escritório Contábil
- Emissão de NFS-e (clientes)
- Visualização e emissão de relatórios

#### Status do projeto
- CRUDs de Prestador e Tomador implementados, login com níveis de acesso implementado com Gates por usuário.
- Emissão de NFS-e pelo Prestador, porém falta a realização de testes relacionados aos cálculos dos valores da nota.
- Layout da nota já está validado e a nota gerada já busca valores dinamicamente e persiste no banco.
- Tomador ainda não está sendo inserido dinamicamente no ato de preenchimento da nota
- Serviços relacionados à nota não estão sendo persistidos ainda

#### Implementação futura
- Solicitação de cadastro (Prestador solicita seu cadastro)
- Visualização de relatórios diversos pra cada perfil de acesso
 