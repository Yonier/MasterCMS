<div class="content">
	<div class="container-fluid">
		<div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header" data-background-color="red">
                        <h4 class="title">Advertencias / Consejos</h4>
                        <p class="category">A continuaci&oacute;n le dejamos una lista de advertencias/consejos que deberas tomar en cuenta antes de modificar esta secci&oacute;n:</p>
                    </div>
                    <div class="card-content">
                        <ul>
                            <li>Si no sabe lo que hace, no mueva nada de lo que hay aqui dentro.</li>
                            <li>No cambies el nombre de los temas originales o pueden causar problemas en la instalaci&oacute;n.</li>
                            <li>Si creara un tema basado en otro, recuerde dar sus respectivos creditos.</li>
                            <li>Para saber como crear un tema desde 0 visita la <a href="https://github.com/DenzelCode/MasterCMS/blob/master/DOC.md" target="_blank">documentaci&oacute;n</a> para desarrolladores de temas.</li>
                        </ul>
                    </div>
                </div>
            </div>
			<div class="col-lg-6 col-md-12">
				<div class="card card-nav-tabs">
                    <div class="card-header" data-background-color="purple">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">Subir:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="active">
                                    <a href="#uploadTmp" data-toggle="tab">
                                        <i class="material-icons">web</i>
                                        Theme
                                    <div class="ripple-container"></div></a>
                                </li>
                                <!-- <li>
                                    <a href="#uploadStl" data-toggle="tab">
                                        <i class="material-icons">web_asset</i>
                                        Styles
                                    <div class="ripple-container"></div></a>
                                </li> -->
                                <li>
                                    <a href="#actInfo" data-toggle="tab">
                                        <i class="material-icons">info</i>
                                        Informaci&oacute;n del tema actual
                                    <div class="ripple-container"></div></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="active tab-pane" id="uploadTmp">
                            <h4>Subir Theme</h4>
                                <div id="forerror"></div>
                                <form action="" method="POST" id="uploadTemplateFormulary">
                                    <div class="form-group">
                                      <input type="file" name="template" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo unicamente en formato ZIP">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="uploadTemplate"><i class="fa fa-paper-plane"></i> Subir Theme</button>
                                </form>
                            </div>
                            <!-- <div class="tab-pane" id="uploadStl">
                            <h4>Subir Styles</h4>
                                <div id="forerror2"></div>
                                <form action="" method="POST" id="uploadStylesFormulary">
                                    <div class="form-group">
                                      <input type="file" name="styles" id="inputFile4">
                                      <div class="input-group" style="width: 90%;display: inline-block;">
                                        <input type="text" readonly="" class="form-control" placeholder="Seleccione un archivo unicamente en formato ZIP">
                                      </div>
                                      <span class="input-group-btn input-group-sm" style="width: 5%;display: inline-block;">
                                        <button type="button" class="btn btn-fab btn-fab-mini">
                                          <i class="material-icons">attach_file</i>
                                        </button>
                                      </span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="uploadStyles"><i class="fa fa-paper-plane"></i> Subir Estilos</button>
                                </form>
                            </div> -->
                            <div class="tab-pane" id="actInfo">
                            <h4>Informaci&oacute;n del Theme actual</h4>
                                <ul>
                                    <li><strong>MasterCMS {@master_version}</strong></li>
                                    <li><strong>Name:</strong> {@theme_name}</li>
                                    <li><strong>Description:</strong> {@theme_description}</li>
                                    <li><strong>Version:</strong> {@theme_version}</li>
                                    <li><strong>Author(s):</strong> {@theme_author}</li>
                                    <li><strong>Theme Lang:</strong> {@theme_lang}</li>
                                    <li><strong>Avaliable Langs:</strong> {@theme_langs_list}</li>
                                    <li><strong>Created Date:</strong> {@theme_creation}</li>
                                    <li><strong>Installed Date:</strong> {@theme_installed}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
            <div class="col-lg-6 col-md-12">
                <div class="card card-nav-tabs">
                    <div class="card-header" data-background-color="purple">
                    <div class="nav-tabs-navigation">
                        <div class="nav-tabs-wrapper">
                            <span class="nav-tabs-title">Acciones:</span>
                            <ul class="nav nav-tabs" data-tabs="tabs">
                                <li class="active">
                                    <a href="#changeTM" data-toggle="tab">
                                        <i class="material-icons">build</i>
                                        Cambiar Theme
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#exportTM" data-toggle="tab">
                                        <i class="material-icons">exit_to_app</i>
                                        Exportar Theme
                                    <div class="ripple-container"></div></a>
                                </li>
                                <li>
                                    <a href="#deleteTM" data-toggle="tab">
                                        <i class="material-icons">delete</i>
                                        Eliminar Theme
                                    <div class="ripple-container"></div></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <div class="card-content">
                        <div class="tab-content">
                            <div class="active tab-pane" id="changeTM">
                                <h4>Cambiar Theme</h4>
                                <div id="forerror3"></div>
                                <form action="" method="POST" id="changeThemeFormulary">
                                    <div class="form-group label-floating">
                                        <select name="theme" id="theme" class="form-control">
                                            <option disabled="" selected="" value="0">Seleccione un tema</option>
                                            <?php
                                                if (count($files) == 0) {
                                                    echo "<option value=\"0\" selected disabled>No hay themes disponibles</option>";
                                                } else {
                                                    $styles_rute = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
                                                    $current_theme = $this->hotel->getConfig('template_name');
                                                    foreach ($files as $key) {
                                                        if (file_exists($styles_rute . $key . DS)) {
                                                            if (strtolower($key) == strtolower($current_theme)) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\" selected>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\" selected>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($key == $current_theme) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\" selected disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\" selected disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }    
                                            ?>
                                        </select>
                                        <span class="help-block">Seleccione un Theme para {@name}</span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="changeTheme"><i class="fa fa-paper-plane"></i> Cambiar Theme</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="exportTM">
                                <h4>Exportar Theme</h4>
                                <div id="forerror4"></div>
                                <form action="" method="POST" id="exportThemeFormulary">
                                    <div class="form-group label-floating">
                                        <select name="theme" id="theme" class="form-control">
                                            <option disabled="" selected="" value="0">Seleccione un tema</option>
                                            <?php
                                                if (count($files) == 0) {
                                                    echo "<option value=\"0\" selected disabled>No hay themes disponibles</option>";
                                                } else {
                                                    $styles_rute = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
                                                    $current_theme = $this->hotel->getConfig('template_name');
                                                    foreach ($files as $key) {
                                                        if (file_exists($styles_rute . $key . DS)) {
                                                            if (strtolower($key) == strtolower($current_theme)) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($key == $current_theme) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }    
                                            ?>
                                        </select>
                                        <span class="help-block">Seleccione un Theme para descargarlo</span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="exportTheme"><i class="fa fa-paper-plane"></i> Exportar Theme</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="deleteTM">
                                <h4>Borrar Theme</h4>
                                <div id="forerror5"></div>
                                <form action="" method="POST" id="deleteThemeFormulary">
                                    <div class="form-group label-floating">
                                        <select name="theme" id="theme" class="form-control">
                                            <option disabled="" selected="" value="0">Seleccione un tema</option>
                                            <?php
                                                if (count($files) == 0) {
                                                    echo "<option value=\"0\" selected disabled>No hay themes disponibles</option>";
                                                } else {
                                                    $styles_rute = MAIN_ROOT . 'Resources' . DS . 'Themes' . DS;
                                                    $current_theme = $this->hotel->getConfig('template_name');
                                                    foreach ($files as $key) {
                                                        if (file_exists($styles_rute . $key . DS)) {
                                                            if (strtolower($key) == strtolower($current_theme)) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)}</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)}</option>";
                                                                }
                                                            }
                                                        } else {
                                                            if ($key == $current_theme) {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\" disabled>{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            } else {
                                                                if ($this->hotel->getThemeInfo('installed', $key)) {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} installed at {$this->hotel->getThemeInfo('installed', $key)} > Please install the Styles of this Theme</option>";
                                                                } else {
                                                                    echo "<option value=\"{$key}\">{$this->hotel->getThemeInfo('name', $key)} (Version {$this->hotel->getThemeInfo('version', $key)}) by {$this->hotel->getThemeInfo('author', $key)} > Please install the Styles of this Theme</option>";
                                                                }
                                                            }
                                                        }
                                                    }
                                                }    
                                            ?>
                                        </select>
                                        <span class="help-block">Seleccione un Theme para eliminarlo</span>
                                    </div>
                                    <button class="btn btn-primary btn-block" type="submit" id="deleteTheme"><i class="fa fa-paper-plane"></i> Eliminar Theme</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
</div>
</div>
<script type="text/javascript" src="{@hk_cdn}/js/forms/dashboardThemes.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        uploadTemplateForm();
        // uploadStylesForm();
        changeThemeForm();
        exportThemeForm();
        deleteThemeForm();
    });
</script>