create or replace FUNCTION "admin"."f_creditos_cuota_a_pagar_cuota"(in @credito numeric(9))
returns numeric(17) 

begin 

	declare w_saldo_cuota numeric(17);
	select first(cuota) into w_saldo_cuota 
	from creditos_detalles 
	where credito = @credito 
	and(saldo_cuota = total_cuota or saldo_cuota > 0) 
	order by cuota asc;

return(w_saldo_cuota) end