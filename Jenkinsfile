// 🔹 Jenkinsfile corregido y optimizado
pipeline {
    // 🔹 Ejecuta en cualquier agente disponible
    agent any

    // 🔹 Variables disponibles en todo el pipeline
    environment {
        REGISTRY = "ghcr.io"
        IMAGE_NAME = "${REGISTRY}/mgs-10/web"
        KUBE_CONFIG = credentials('kubeconfig')
        DOCKER_CREDS = credentials('dockerhub-credentials')
    }

    stages {

        // 🔹 ETAPA 1: OBTENER EL CÓDIGO FUENTE
        stage('Checkout Code') {
            steps {
                echo "📥 Descargando código desde GitHub..."
                
                // 🔹 Clonamos el repo dentro del workspace de Jenkins
                checkout([
                    $class: 'GitSCM',
                    branches: [[name: '*/main']],
                    userRemoteConfigs: [[
                        url: 'https://github.com/mgs-10/web.git',
                        credentialsId: 'github-token'
                    ]]
                ])

                // 🔹 Mostramos estado del repo
                sh 'git status'
            }
        }

        // 🔹 ETAPA 2: INSTALAR DEPENDENCIAS
        stage('Install Dependencies') {
            steps {
                echo "📦 Instalando dependencias de PHP..."
                
                sh '''
                    if [ -f "composer.json" ]; then
                        echo "Instalando dependencias con Composer..."
                        docker run --rm -v ${WORKSPACE}:/app composer install --no-dev --optimize-autoloader
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
                    if [ -d "tests" ] || [ -f "phpunit.xml" ]; then
                        echo "Ejecutando tests con PHPUnit..."
                        docker-compose -f docker-compose.yml up --abort-on-container-exit --exit-code-from app
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
                    dockerImage = docker.build("${IMAGE_NAME}:${env.BUILD_NUMBER}", ".")
                    echo "✅ Imagen construida: ${IMAGE_NAME}:${env.BUILD_NUMBER}"
                }
            }
        }

        // 🔹 ETAPA 5: LOGIN Y PUSH AL REGISTRY
        stage('Push to Registry') {
            steps {
                echo "📤 Subiendo imagen al registry..."
                
                script {
                    docker.withRegistry("https://${REGISTRY}", 'dockerhub-credentials') {
                        dockerImage.push()
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
                    mkdir -p ~/.kube
                    echo "$KUBE_CONFIG" | base64 -d > ~/.kube/config
                    echo "🔍 Verificando conexión a Kubernetes..."
                    kubectl cluster-info
                    kubectl get nodes

                    if ! kubectl get deployment php-app > /dev/null 2>&1; then
                        echo "📝 Aplicando configuración inicial de Kubernetes..."
                        kubectl apply -f k8s/
                    fi

                    echo "🔄 Actualizando deployment con nueva imagen..."
                    kubectl set image deployment/php-app php-app=${IMAGE_NAME}:${env.BUILD_NUMBER} --record
                    kubectl rollout status deployment/php-app --timeout=300s
                    echo "✅ Deployment completado exitosamente"
                """
            }
        }

        // 🔹 ETAPA 7: VERIFICAR DESPLIEGUE (Smoke Test)
        stage('Smoke Test') {
            steps {
                echo "🔍 Verificando que la aplicación funciona..."
                
                sh """
                    echo "⏳ Esperando 30 segundos para que la aplicación esté lista..."
                    sleep 30

                    APP_URL=\$(minikube service php-service --url)
                    echo "🌐 URL de la aplicación: \$APP_URL"

                    echo "🧪 Realizando smoke test..."
                    curl -f --retry 3 --retry-delay 10 \$APP_URL || exit 1

                    HTTP_STATUS=\$(curl -s -o /dev/null -w "%{http_code}" \$APP_URL)
                    if [ "\$HTTP_STATUS" -eq 200 ]; then
                        echo "✅ Smoke test exitoso"
                    else
                        echo "❌ Smoke test falló - HTTP Status: \$HTTP_STATUS"
                        exit 1
                    fi
                """
            }
        }

    }

    // 🔹 POST: acciones posteriores a la ejecución
    post {
        always {
            node {
                echo "🏁 Pipeline completado - Build #${env.BUILD_NUMBER}"
                sh 'docker system prune -f || true'
            }
        }

        success {
            echo "🎉 ¡Despliegue exitoso!"
            emailext (
                subject: "✅ Despliegue Exitoso - Build ${env.BUILD_NUMBER}",
                body: """
                El pipeline se ejecutó exitosamente:
                Proyecto: ${env.JOB_NAME}
                Build: #${env.BUILD_NUMBER}
                URL: ${env.BUILD_URL}
                """,
                to: "devops@tuempresa.com"
            )
        }

        failure {
            node {
                echo "💥 El pipeline falló. Revisar logs."
                emailext (
                    subject: "❌ Falla en Pipeline - Build ${env.BUILD_NUMBER}",
                    body: """
                    El pipeline falló:
                    Proyecto: ${env.JOB_NAME}
                    Build: #${env.BUILD_NUMBER}
                    URL: ${env.BUILD_URL}
                    """,
                    to: "moi_america1999@hotmail.com"
                )

                sh """
                    kubectl rollout undo deployment/php-app --timeout=300s || true
                    echo "🔄 Rollback ejecutado"
                """
            }
        }

        changed {
            echo "📊 Pipeline cambió de estado"
        }
    }
}
