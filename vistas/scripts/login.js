/**
 * Login Pauny - mensaje de error estable (no ocultar al hacer focus).
 */
(function() {
	'use strict';

	function get(id) { return document.getElementById(id); }

	function parseJson(str) {
		if (typeof str !== 'string') return str;
		str = str.replace(/^\uFEFF/, '');
		try { return JSON.parse(str); } catch (e) { return null; }
	}

	function init() {
		var form = get('frmAcceso');
		var btn = get('btnIngresar');
		var btnText = get('btnIngresarText');
		var logina = get('logina');
		var clavea = get('clavea');
		var errorBar = get('loginErrorBar');
		var errorBarText = get('loginErrorBarText');
		var errorBarClose = get('loginErrorBarClose');
		var loginAlert = get('loginAlert');
		var loginAlertText = get('loginAlertText');

		if (!form || !errorBar || !errorBarText) return;

		function hideError() {
			errorBar.style.display = 'none';
			errorBar.classList.remove('show');
			if (loginAlert) {
				loginAlert.style.display = 'none';
				loginAlert.classList.remove('show');
			}
		}

		function showError(mensaje) {
			var texto = mensaje || 'Usuario o contraseña incorrectos.';
			errorBarText.textContent = texto;
			errorBar.style.display = 'block';
			errorBar.style.visibility = 'visible';
			errorBar.style.opacity = '1';
			errorBar.classList.add('show');
			if (loginAlertText) loginAlertText.textContent = texto;
			if (loginAlert) {
				loginAlert.style.display = 'flex';
				loginAlert.style.visibility = 'visible';
				loginAlert.style.opacity = '1';
				loginAlert.classList.add('show');
				loginAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}
			// No hacer focus aquí: antes teníamos clavea.focus() y el listener
			// 'focus' llamaba hideError() y ocultaba el mensaje al instante.
			// Opcional: focus con delay para que se vea el mensaje primero
			if (clavea) {
				setTimeout(function() { clavea.focus(); }, 300);
			}
		}

		if (errorBarClose) {
			errorBarClose.addEventListener('click', hideError);
		}

		function setLoading(loading) {
			if (!btn || !btnText) return;
			btn.disabled = loading;
			btnText.innerHTML = loading
				? '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Ingresando...'
				: 'Ingresar';
		}

		function validarCampos() {
			var u = (logina && logina.value ? logina.value.trim() : '');
			var c = (clavea && clavea.value ? clavea.value.trim() : '');
			if (!u) {
				showError('Ingrese su nombre de usuario.');
				if (logina) logina.focus();
				return false;
			}
			if (!c) {
				showError('Ingrese su contraseña.');
				if (clavea) setTimeout(function() { clavea.focus(); }, 100);
				return false;
			}
			return true;
		}

		form.addEventListener('submit', function(e) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			hideError();

			if (!validarCampos()) return false;

			var usuario = logina.value.trim();
			var clave = clavea.value;
			setLoading(true);

			var formData = new FormData();
			formData.append('logina', usuario);
			formData.append('clavea', clave);

			fetch('../ajax/usuario.php?op=verificar', {
				method: 'POST',
				body: formData
			})
				.then(function(response) {
					return response.text();
				})
				.then(function(texto) {
					setLoading(false);
					var obj = parseJson(texto);
					if (obj && obj.ok === true) {
						window.location.href = 'escritorio.php';
						return;
					}
					var msg = (obj && obj.mensaje) ? obj.mensaje : 'Usuario o contraseña incorrectos. Verifique sus datos e intente nuevamente.';
					showError(msg);
				})
				.catch(function() {
					setLoading(false);
					showError('No se pudo conectar. Verifique su conexión e intente nuevamente.');
				});

			return false;
		});

		// Ocultar error solo cuando el usuario escribe (input), NO en focus,
		// para no ocultar el mensaje al hacer focus después de showError().
		if (logina && clavea) {
			logina.addEventListener('input', hideError);
			clavea.addEventListener('input', hideError);
		}

		// Mostrar/ocultar contraseña
		var toggleBtn = get('togglePassword');
		var toggleIcon = get('togglePasswordIcon');
		if (toggleBtn && clavea && toggleIcon) {
			toggleBtn.addEventListener('click', function() {
				if (clavea.type === 'password') {
					clavea.type = 'text';
					toggleIcon.className = 'fa fa-eye-slash';
					toggleBtn.setAttribute('title', 'Ocultar contraseña');
				} else {
					clavea.type = 'password';
					toggleIcon.className = 'fa fa-eye';
					toggleBtn.setAttribute('title', 'Mostrar contraseña');
				}
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
