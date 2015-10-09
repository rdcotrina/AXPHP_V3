USE [erpsolution]
GO
/****** Object:  StoredProcedure [dbo].[sp_sisAccionesGrid]    Script Date: 09/10/2015 11:08:08 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
-- =============================================
-- Author:		<Author,,Name>
-- Create date: <Create Date,,>
-- Description:	<Description,,>
-- =============================================
ALTER PROCEDURE [dbo].[sp_sisAccionesGrid]
	@iDisplayStart INT,
    @iDisplayLength INT, 
    @iOrderCol VARCHAR(200),
    @sFilterCols VARCHAR(300),
    @sExport CHAR(1)
AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	-- SET QUOTED_IDENTIFIER OFF; -- activa comillas dobles

    DECLARE @orderby VARCHAR(300) = '';
	DECLARE @filterCols VARCHAR(300) = '';
	DECLARE @limit VARCHAR(300) = '';
	DECLARE @limit1 int;
	DECLARE @limit2 int;

	IF @sFilterCols <> '' 
		begin
			SET @filterCols = REPLACE(@sFilterCols,'&quot;', char(39));
			SET @filterCols = REPLACE(@filterCols,'*','%');
			SET @filterCols = REPLACE(@filterCols,'&gt;','>');
			SET @filterCols = REPLACE(@filterCols,'&lt;','<');
		end

	IF @iOrderCol <> '' 
		begin
			SET @orderby = CONCAT(' ORDER BY ',@iOrderCol);
		end

	set @limit1 = @iDisplayLength * (@iDisplayStart-1);
	set @limit2 = @iDisplayLength * @iDisplayStart;

	SET @limit = CONCAT(' WHERE rownum > ',@limit1,' AND rownum <= ',@limit2);
	-- verificar si data se exportara
	IF @sExport = '1' 
		begin
			SET @limit = ''; -- si se exporta no hay limit, se debe mostrar todos los registros
		end

	exec('
	declare @countx int;
	SELECT 
		@countx = COUNT(*) 
	FROM mae_accion
	WHERE 1 = 1
	'+@filterCols+';

	with tabla as(
		SELECT 
			@countx as total,
			ROW_NUMBER() OVER(ORDER BY idaccion) AS rownum,
			estado,
			idaccion,
			descripcion,
			icono,
			theme,
			alias
		FROM mae_accion
		WHERE 1 = 1
		'+@filterCols+'  
	)
	SELECT 
		total,
		estado,
		idaccion,
		descripcion,
		icono,
		theme,
		alias
	FROM tabla
	'+@limit+'
	'+@orderby+';
	');
	
END
