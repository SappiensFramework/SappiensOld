CREATE
 ALGORITHM = UNDEFINED
 VIEW `v_uf_cidade`
 (ufCidadeCod, ufCidadeNome, ufCidadeIbgeCod, ufCidadeArea, ufCod, ufSigla, 
 	ufNome, ufIbgeCod, ufCidadeNomeUfNome, ufCidadeNomeUfSigla)
 AS SELECT a.ufCidadeCod, a.ufCidadeNome, a.ufCidadeIbgeCod, a.ufCidadeArea, 
 b.ufCod, b.ufSigla, b.ufNome, b.ufIbgeCod, 
 CONCAT(a.ufCidadeNome,', ',b.ufNome) AS ufCidadeNomeUfNome, 
 CONCAT(a.ufCidadeNome,'/',b.ufSigla) AS ufCidadeNomeUfSigla FROM uf_cidade a, 
 uf b WHERE a.ufCod = b.ufCod ORDER BY a.ufCidadeNome