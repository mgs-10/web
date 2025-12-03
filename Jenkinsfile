// 🔹 Define un pipeline de Jenkins
pipeline {
    // 🔹 Ejecuta en cualquier agente disponible
    agent any

    // 🔹 Variables disponibles en todo el pipeline
    environment {
        // 🔹 Registry de GitHub Packages
        REGISTRY = "ghcr.io"
        
        // 🔹 Nombre completo de tu imagen Docker
        // Formato: ghcr.io/usuario/repo
        IMAGE_NAME = "${REGISTRY}/mgs-10/web"
        
        // 🔹 Configuración de Kubernetes (credencial segura)
        KUBE_CONFIG = credentials('kubeconfig')
        
        // 🔹 Credenciales para Docker (acceder a usuario y password por separado)
        DOCKER_CREDS = credentials('dockerhub-credentials')
    }

    // 🔹 ETAPAS DEL PIPELINE - Secuencia de ejecución
    stages {
        
        // 🔹 ETAPA 1: OBTENER EL CÓDIGO FUENTE
        stage('Checkout Code') {
            steps {
                echo "📥 Descargando código desde GitHub..."
                
                // 🔹 Clona el repositorio de GitHub
                git(
                    branch: 'main',                                    // 🔹 Rama a clonar
                    url: 'https://github.com/mgs-10/web.git', // 🔹 URL de tu repo
                    credentialsId: 'github-token'                      // 🔹 Usa el token para autenticar
                )
                
                // 🔹 Muestra información del commit
                sh 'git log --oneline -5'
            }
        }

        // 🔹 ETAPA 2: INSTALAR DEPENDENCIAS
        stage('Install Dependencies') {
            steps {
                echo "📦 Instalando dependencias de PHP..."
                
                // 🔹 Ejecuta dentro de un contenedor temporal con PHP
                sh '''
                    # Verificar que tenemos composer.json
                    if [ -f "composer.json" ]; then
                        echo "Instalando dependencias con Composer..."
                        docker run --rm -v $(pwd):/app composer install --no-dev --optimize-autoloader
                    else
                        echo "No hay composer.json, saltando instalación de dependencias"
                    fi
                '''
            }
        }

        // 🔹 ETAPA 3: EJECUTAR TESTS
        stage('Run Tests') {
            steps {
                echo "🧪 Ejecutando tests PHP..."
                
                sh '''
                    # Verificar si existen tests
                    if [ -d "tests" ] || [ -f "phpunit.xml" ]; then
                        echo "Ejecutando tests con PHPUnit..."
                        
                        # 🔹 Usar docker-compose para tests con base de datos
                        docker-compose -f docker-compose.yml up --abort-on-container-exit --exit-code-from app
                        
                        # 🔹 El comando anterior termina con exit code 0 si tests pasan, 1 si fallan
                    else
                        echo "No hay tests configurados, continuando..."
                    fi
                '''
            }
        }

        // 🔹 ETAPA 4: CONSTRUIR IMAGEN DOCKER
        stage('Build Docker Image') {
            steps {
                echo "🐳 Construyendo imagen Docker..."
                
                script {
                    // 🔹 Construye la imagen Docker
                    // Usa el Dockerfile en el directorio actual
                    // Tag: nombre_imagen:numero_build
                    dockerImage = docker.build(
                        "${IMAGE_NAME}:${env.BUILD_NUMBER}", 
                        "."
                    )
                    
                    echo "✅ Imagen construida: ${IMAGE_NAME}:${env.BUILD_NUMBER}"
                }
            }
        }

        // 🔹 ETAPA 5: LOGIN Y PUSH AL REGISTRY
        stage('Push to Registry') {
            steps {
                echo "📤 Subiendo imagen al registry..."
                
                script {
                    // 🔹 Login al registry de GitHub Packages
                    docker.withRegistry("https://${REGISTRY}", 'dockerhub-credentials') {
                        // 🔹 Sube la imagen al registry
                        dockerImage.push()
                        
                        // 🔹 También crea un tag "latest"
                        dockerImage.push("latest")
                    }
                    
                    echo "✅ Imagen subida exitosamente"
                }
            }
        }

        // 🔹 ETAPA 6: DESPLEGAR EN KUBERNETES
        stage('Deploy to Kubernetes') {
            steps {
                echo "☸️ Desplegando en Kubernetes..."
                
                sh """
                    # 🔹 Crear directorio de configuración de Kubernetes
                    mkdir -p ~/.kube
                    
                    # 🔹 Guardar la configuración de Kubernetes desde la credencial
                    # La variable KUBE_CONFIG contiene el config en base64
                    echo "$KUBE_CONFIG" | base64 -d > ~/.kube/config
                    
                    # 🔹 Verificar que podemos conectar a Kubernetes
                    echo "🔍 Verificando conexión a Kubernetes..."
                    kubectl cluster-info
                    kubectl get nodes
                    
                    # 🔹 Aplicar los archivos de configuración si no existen
                    if ! kubectl get deployment php-app > /dev/null 2>&1; then
                        echo "📝 Aplicando configuración inicial de Kubernetes..."
                        kubectl apply -f k8s/
                    fi
                    
                    # 🔹 Actualizar la imagen del deployment
                    echo "🔄 Actualizando deployment con nueva imagen..."
                    kubectl set image deployment/php-app \
                        php-app=${IMAGE_NAME}:${env.BUILD_NUMBER} \
                        --record
                    
                    # 🔹 Esperar a que el rollout termine
                    echo "⏳ Esperando a que el deployment se complete..."
                    kubectl rollout status deployment/php-app --timeout=300s
                    
                    echo "✅ Deployment completado exitosamente"
                """
            }
        }

        // 🔹 ETAPA 7: VERIFICAR DESPLIEGUE
        stage('Smoke Test') {
            steps {
                echo "🔍 Verificando que la aplicación funciona..."
                
                sh """
                    # 🔹 Esperar a que la aplicación esté lista
                    echo "⏳ Esperando 30 segundos para que la aplicación esté lista..."
                    sleep 30
                    
                    # 🔹 Obtener la URL del servicio
                    APP_URL=\$(minikube service php-service --url)
                    echo "🌐 URL de la aplicación: \$APP_URL"
                    
                    # 🔹 Hacer una petición HTTP a la aplicación
                    # -f: falla silenciosamente en errores HTTP
                    # --retry 3: reintenta 3 veces si falla
                    echo "🧪 Realizando smoke test..."
                    curl -f --retry 3 --retry-delay 10 \$APP_URL || exit 1
                    
                    # 🔹 Verificar que responde con código 200
                    HTTP_STATUS=\$(curl -s -o /dev/null -w "%{http_code}" \$APP_URL)
                    if [ "\$HTTP_STATUS" -eq 200 ]; then
                        echo "✅ Smoke test exitoso - Aplicación respondiendo correctamente"
                    else
                        echo "❌ Smoke test falló - HTTP Status: \$HTTP_STATUS"
                        exit 1
                    fi
                """
            }
        }
    }

    // 🔹 ACCIONES POSTERIORES A LA EJECUCIÓN
    post {
        // 🔹 SIEMPRE se ejecuta (éxito o falla)
        always {
            echo "🏁 Pipeline completado - Build #${env.BUILD_NUMBER}"
            
            // 🔹 Limpiar contenedores temporales
            sh 'docker system prune -f || true'
        }
        
        // 🔹 Solo si el pipeline fue EXITOSO
        success {
            echo "🎉 ¡Despliegue exitoso! La aplicación está funcionando."
            
            // 🔹 Opcional: Enviar notificación a Slack/Email
            emailext (
                subject: "✅ Despliegue Exitoso - Build ${env.BUILD_NUMBER}",
                body: """
                El pipeline se ejecutó exitosamente:
                
                Proyecto: ${env.JOB_NAME}
                Build: #${env.BUILD_NUMBER}
                Estado: SUCCESS
                URL: ${env.BUILD_URL}
                
                La aplicación fue desplegada en Kubernetes correctamente.
                """,
                to: "devops@tuempresa.com"
            )
        }
        
        // 🔹 Solo si el pipeline FALLÓ
        failure {
            echo "💥 El pipeline falló. Revisar logs para más detalles."
            
            // 🔹 Notificación de error
            emailext (
                subject: "❌ Falla en Pipeline - Build ${env.BUILD_NUMBER}",
                body: """
                El pipeline falló:
                
                Proyecto: ${env.JOB_NAME}
                Build: #${env.BUILD_NUMBER}
                Estado: FAILED
                URL: ${env.BUILD_URL}
                
                Por favor revisar los logs para identificar el problema.
                """,
                to: "moi_america1999@hotmail.com"
            )
            
            // 🔹 Opcional: Rollback automático
            sh """
                # Intentar rollback si el deployment falló
                kubectl rollout undo deployment/php-app --timeout=300s || true
                echo "🔄 Rollback ejecutado"
            """
        }
        
        // 🔹 Se ejecuta después de cada ejecución (success, failure, unstable)
        changed {
            echo "📊 Pipeline cambió de estado"
        }
    }
}
