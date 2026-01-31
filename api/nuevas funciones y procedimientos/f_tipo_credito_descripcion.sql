ALTER FUNCTION "admin"."f_tipo_credito_descripcion"(@tipo numeric) 
returns varchar(20)                 
begin    

declare @tipo varchar(20);    

select descripcion  into @tipo  
from tipos_de_credito 
where tipo_de_credito = @tipo;    

return @tipo;  

end