CREATE
 ALGORITHM = UNDEFINED
 VIEW `v_uf_cidade_bairro_endereco`
 (ufCidadeBairroEnderecoCep, ufCidadeBairroEnderecoNome, ufCidadeBairroCod, 
 	ufCidadeBairroNome, ufCidadeCod, ufCidadeNome, ufCidadeIbgeCod, 
 	ufCidadeArea, ufCod, ufSigla, ufNome, ufIbgeCod, ufCidadeNomeUfNome, 
 	ufCidadeNomeUfSigla)
 AS SELECT a.ufCidadeBairroEnderecoCep, a.ufCidadeBairroEnderecoNome, 
 b.ufCidadeBairroCod, b.ufCidadeBairroNome, c.ufCidadeCod, c.ufCidadeNome, 
 c.ufCidadeIbgeCod, c.ufCidadeArea, d.ufCod, d.ufSigla, d.ufNome, d.ufIbgeCod, 
 CONCAT(c.ufCidadeNome,', ',d.ufNome) AS ufCidadeNomeUfNome, 
 CONCAT(c.ufCidadeNome,'/',d.ufSigla) AS ufCidadeNomeUfSigla
FROM uf_cidade_bairro_endereco a, uf_cidade_bairro b, uf_cidade c, uf d
WHERE a.ufCidadeBairroCod = b.ufCidadeBairroCod
AND b.ufCidadeCod = c.ufCidadeCod
AND c.ufCod = d.ufCod